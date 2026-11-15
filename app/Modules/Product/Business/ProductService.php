<?php

namespace App\Modules\Product\Business;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ServiceSection;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\ImageManager;

class ProductService
{
    /*
    |--------------------------------------------------------------------------
    | Upload
    |--------------------------------------------------------------------------
    */

    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);

        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/product/";
    }

    /**
     * Converte valores monetários para o formato decimal.
     */
    private function normalizePrice($value): string
    {
        if ($value === null || $value === '') {
            return '0.00';
        }

        $value = str_replace(
            ['R$', ' ', "\u{A0}"],
            '',
            (string) $value
        );

        // Formato brasileiro: 1.234,56
        if (str_contains($value, ',')) {
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);
        }

        return number_format((float) $value, 2, '.', '');
    }

    /**
     * Salva uma imagem ou arquivo.
     */
    private function storeUploadedFile(
        UploadedFile $file,
        string $pathUpload,
        ImageManager $manager
    ): string {
        $mime = $file->getMimeType();

        // SVG é armazenado sem conversão
        if ($mime === 'image/svg+xml') {
            $filename = Str::uuid() . '.svg';

            Storage::disk('public')->putFileAs(
                $pathUpload,
                $file,
                $filename
            );

            return $pathUpload . $filename;
        }

        // Imagens são convertidas para AVIF
        if (str_starts_with($mime, 'image/')) {
            $filename = Str::uuid() . '.avif';

            $image = $manager
                ->read($file)
                ->toAvif(quality: 90)
                ->toString();

            Storage::disk('public')->put(
                $pathUpload . $filename,
                $image
            );

            return $pathUpload . $filename;
        }

        // Outros arquivos mantêm a extensão original
        $extension = $file->getClientOriginalExtension();
        $filename = Str::uuid() . '.' . $extension;

        Storage::disk('public')->putFileAs(
            $pathUpload,
            $file,
            $filename
        );

        return $pathUpload . $filename;
    }

    /**
     * Prepara os dados principais do produto.
     */
    private function prepareProductData(
        Request $request,
        array $data,
        ?Product $product = null,
        array &$newFiles = [],
        array &$oldFiles = []
    ): array {
        $data['active'] = $request->boolean('active');

        if (!empty($request->title)) {
            $data['slug'] = Str::slug($request->title);
        }

        if (isset($data['price'])) {
            $data['price'] = $this->normalizePrice($data['price']);
        }

        // Mantém compatibilidade com o campo antigo sizes.
        // Quando a estrutura nova estiver totalmente implantada,
        // esse tratamento poderá ser removido.
        if (array_key_exists('sizes', $data)) {
            $sizes = array_values(
                array_filter(
                    $data['sizes'] ?? [],
                    fn ($size) => !is_null($size) && trim($size) !== ''
                )
            );

            $data['sizes'] = json_encode($sizes);
        } else {
            $data['sizes'] = null;
        }

        $pathUpload = $this->getPathUpload();

        $manager = new ImageManager(new ImagickDriver());

        /*
        |--------------------------------------------------------------------------
        | Imagem do produto
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('path_image')) {
            $path = $this->storeUploadedFile(
                $request->file('path_image'),
                $pathUpload,
                $manager
            );

            $data['path_image'] = $path;
            $newFiles[] = $path;

            if ($product && $product->path_image) {
                $oldFiles[] = $product->path_image;
            }
        } elseif (
            $product &&
            $request->has('delete_path_image')
        ) {
            $data['path_image'] = null;

            if ($product->path_image) {
                $oldFiles[] = $product->path_image;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Arquivo do produto
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('path_file')) {
            $path = $this->storeUploadedFile(
                $request->file('path_file'),
                $pathUpload,
                $manager
            );

            $data['path_file'] = $path;
            $newFiles[] = $path;

            if ($product && $product->path_file) {
                $oldFiles[] = $product->path_file;
            }
        } elseif (
            $product &&
            $request->has('delete_path_file')
        ) {
            $data['path_file'] = null;

            if ($product->path_file) {
                $oldFiles[] = $product->path_file;
            }
        }

        // Os arquivos não devem ser enviados como atributos do Model.
        unset(
            $data['delete_path_image'],
            $data['delete_path_file']
        );

        return $data;
    }

    /**
     * Remove arquivos antigos somente depois de salvar o registro.
     */
    private function deleteOldFiles(array $files): void
    {
        foreach (array_unique($files) as $file) {
            if ($file) {
                Storage::disk('public')->delete($file);
            }
        }
    }

    /**
     * Remove arquivos recém-criados em caso de falha.
     */
    private function cleanupNewFiles(array $files): void
    {
        foreach ($files as $file) {
            if ($file) {
                Storage::disk('public')->delete($file);
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Composição do produto
    |--------------------------------------------------------------------------
    */

    /**
     * Separa os dados das tabelas relacionadas ao produto.
     */
    private function extractComposition(array &$data): array
    {
        $composition = [];

        $fields = [
            'options',
            'combo_items',
            'combo_addons',
        ];

        foreach ($fields as $field) {
            if (array_key_exists($field, $data)) {
                $composition[$field] = $data[$field] ?? [];
            }

            unset($data[$field]);
        }

        return $composition;
    }

    /**
     * Sincroniza as opções e a composição do produto.
     */
    private function syncComposition(
        Product $product,
        array $composition,
        bool $creating = false
    ): void {
        $isCombo = $product->product_type === 'combo';

        /*
        |--------------------------------------------------------------------------
        | Produto normal
        |--------------------------------------------------------------------------
        */

        if (!$isCombo) {
            // Remove composição anterior de combo, se houver.
            $product->comboItems()->delete();
            $product->comboAddons()->delete();

            // Atualiza as opções somente se foram enviadas.
            if (
                $creating ||
                array_key_exists('options', $composition)
            ) {
                $product->options()->delete();

                $options = $composition['options'] ?? [];

                $this->createOptions($product, $options);
            }

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Produto combo
        |--------------------------------------------------------------------------
        */

        // Combo não utiliza opções diretamente no produto.
        $product->options()->delete();

        // Sincroniza os itens do combo.
        if (
            $creating ||
            array_key_exists('combo_items', $composition)
        ) {
            $product->comboItems()->delete();

            $items = $composition['combo_items'] ?? [];

            $this->createComboItems($product, $items);
        }

        // Sincroniza os adicionais do combo.
        if (
            $creating ||
            array_key_exists('combo_addons', $composition)
        ) {
            $product->comboAddons()->delete();

            $addons = $composition['combo_addons'] ?? [];

            $this->createComboAddons($product, $addons);
        }
    }

    /**
     * Cria opções diretamente vinculadas ao produto.
     */
    private function createOptions(
        Product $product,
        array $options
    ): void {
        foreach ($options as $optionData) {
            unset(
                $optionData['id'],
                $optionData['tenant_id'],
                $optionData['product_id'],
                $optionData['combo_item_id']
            );

            $product->options()->create($optionData);
        }
    }

    /**
     * Cria os itens do combo e suas respectivas opções.
     */
    private function createComboItems(
        Product $product,
        array $items
    ): void {
        foreach ($items as $itemData) {
            $options = $itemData['options'] ?? [];

            unset(
                $itemData['id'],
                $itemData['options'],
                $itemData['tenant_id'],
                $itemData['product_id']
            );

            // Cria o item pertencente ao combo.
            $comboItem = $product->comboItems()->create($itemData);

            // Cria as opções disponíveis para esse item.
            foreach ($options as $optionData) {
                unset(
                    $optionData['id'],
                    $optionData['tenant_id'],
                    $optionData['product_id'],
                    $optionData['combo_item_id']
                );

                $comboItem->options()->create($optionData);
            }
        }
    }

    /**
     * Cria os adicionais do combo.
     */
    private function createComboAddons(
        Product $product,
        array $addons
    ): void {
        foreach ($addons as $addonData) {
            unset(
                $addonData['id'],
                $addonData['tenant_id'],
                $addonData['product_id']
            );

            if (isset($addonData['price'])) {
                $addonData['price'] = $this->normalizePrice(
                    $addonData['price']
                );
            }

            $product->comboAddons()->create($addonData);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Listagem
    |--------------------------------------------------------------------------
    */

    public function getIndexData(
        Request $request,
        ThemeManager $themeManager
    ): array {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        $check = checkPermission(
            'products',
            'produtos.visualizar',
            $settingTheme
        );

        if ($check !== true) {
            return ['forbidden' => $check];
        }

        $serviceSection = ServiceSection::whereIn(
            'section',
            ['product']
        )
            ->get()
            ->keyBy('section');

        $categories = ProductCategory::active()
            ->sorting()
            ->get();

        $productsQuery = Product::with(['category']);

        if ($request->filled('title')) {
            $productsQuery->where(
                'title',
                'like',
                '%' . $request->title . '%'
            );
        }

        if ($request->filled('product_category_id')) {
            $productsQuery->where(
                'product_category_id',
                $request->product_category_id
            );
        }

        $products = $productsQuery
            ->sorting()
            ->paginate(60)
            ->withQueryString();

        $productCategory = [];

        foreach ($categories as $category) {
            $productCategory[$category->id] = $category->title;
        }

        $theme = $themeManager;
        $themeData = $themeManager->theme();

        return compact(
            'products',
            'categories',
            'productCategory',
            'theme',
            'themeData',
            'settingTheme',
            'serviceSection'
        );
    }


    public function getCreateData(ThemeManager $themeManager): array
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (
            !$user->hasRole('Super') &&
            !$user->can('usuario.tornar usuario master') &&
            !(
                $user->hasPermissionTo('produtos.visualizar') &&
                $user->hasPermissionTo('produtos.criar')
            )
        ) {
            return [
                'forbidden' => view(
                    'admin.error.403',
                    compact('settingTheme')
                ),
            ];
        }

        $categories = ProductCategory::active()
            ->sorting()
            ->get();

        $brands = Brand::active()
            ->sorting()
            ->get();

        $theme = $themeManager;
        $themeData = $themeManager->theme();

        return [
            'categories' => $categories,
            'brands' => $brands,

            'productCategory' => $categories->pluck('title', 'id')->toArray(),
            'productBrand' => $brands->pluck('title', 'id')->toArray(),

            'theme' => $theme,
            'themeData' => $themeData,
            'settingTheme' => $settingTheme,
        ];
    }

    public function getEditData(
        Product $product,
        ThemeManager $themeManager
    ): array {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (
            !$user->hasRole('Super') &&
            !$user->can('usuario.tornar usuario master') &&
            !(
                $user->hasPermissionTo('produtos.visualizar') &&
                $user->hasPermissionTo('produtos.editar')
            )
        ) {
            return [
                'forbidden' => view(
                    'admin.error.403',
                    compact('settingTheme')
                ),
            ];
        }

        // Carrega os relacionamentos necessários para a edição.
        $product->load([
            'category',
            'brand',
            'galleries',
            'options',
            'comboItems.options',
            'comboAddons',
        ]);

        $categories = ProductCategory::active()
            ->sorting()
            ->get();

        $brands = Brand::active()
            ->sorting()
            ->get();

        $theme = $themeManager;
        $themeData = $themeManager->theme();

        return [
            'product' => $product,

            'categories' => $categories,
            'brands' => $brands,

            'productCategory' => $categories->pluck('title', 'id')->toArray(),
            'productBrand' => $brands->pluck('title', 'id')->toArray(),

            'theme' => $theme,
            'themeData' => $themeData,
            'settingTheme' => $settingTheme,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(ProductStoreRequest $request): Product
    {
        $data = $request->all();

        // Separa os dados das tabelas relacionadas.
        $composition = $this->extractComposition($data);

        $newFiles = [];
        $oldFiles = [];

        // Prepara os dados do produto principal.
        $data = $this->prepareProductData(
            $request,
            $data,
            null,
            $newFiles,
            $oldFiles
        );

        try {
            $product = DB::transaction(function () use (
                $data,
                $composition
            ) {
                // Cria o produto principal.
                $product = Product::create($data);

                // Cria as variantes e a composição.
                $this->syncComposition(
                    $product,
                    $composition,
                    true
                );

                return $product;
            });

            return $product->load([
                'options',
                'comboItems.options',
                'comboAddons',
            ]);
        } catch (\Throwable $e) {
            // Evita deixar arquivos órfãos se o cadastro falhar.
            $this->cleanupNewFiles($newFiles);

            throw $e;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Upload CKEditor
    |--------------------------------------------------------------------------
    */

    public function uploadImageCkeditor(Request $request): array
    {
        if (!$request->hasFile('upload')) {
            return [
                'uploaded' => 0,
                'error' => [
                    'message' => 'Upload falhou.',
                ],
            ];
        }

        $file = $request->file('upload');

        $pathUpload = $this->getPathUpload();

        $manager = new ImageManager(new ImagickDriver());

        $path = $this->storeUploadedFile(
            $file,
            $pathUpload,
            $manager
        );

        $filename = basename($path);

        return [
            'uploaded' => 1,
            'fileName' => $filename,
            'url' => asset('storage/' . $path),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        ProductUpdateRequest $request,
        Product $product
    ): Product {
        $data = $request->all();

        // Separa os dados das tabelas relacionadas.
        $composition = $this->extractComposition($data);

        $newFiles = [];
        $oldFiles = [];

        // Prepara os dados do produto principal.
        $data = $this->prepareProductData(
            $request,
            $data,
            $product,
            $newFiles,
            $oldFiles
        );

        try {
            $product = DB::transaction(function () use (
                $product,
                $data,
                $composition
            ) {
                // Atualiza o produto principal.
                $product->fill($data)->save();

                // Atualiza as variantes e a composição.
                $this->syncComposition(
                    $product,
                    $composition
                );

                return $product;
            });

            // Remove os arquivos anteriores após o commit.
            $this->deleteOldFiles($oldFiles);

            return $product->load([
                'options',
                'comboItems.options',
                'comboAddons',
            ]);
        } catch (\Throwable $e) {
            // Remove somente os arquivos novos em caso de falha.
            $this->cleanupNewFiles($newFiles);

            throw $e;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Exclusão
    |--------------------------------------------------------------------------
    */

    public function delete(Product $product): void
    {
        DB::transaction(function () use ($product) {
            $product->delete();
        });

        $this->deleteOldFiles([
            $product->path_image,
            $product->path_file,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Exclusão múltipla
    |--------------------------------------------------------------------------
    */

    public function destroySelected(Request $request): array
    {
        $ids = $request->input('deleteAll', []);

        $products = Product::whereIn('id', $ids)->get();

        $files = [];

        foreach ($products as $product) {
            activity()
                ->causedBy(Auth::user())
                ->performedOn($product)
                ->event('multiple_deleted')
                ->withProperties([
                    'attributes' => [
                        'id' => $product->id,
                        'title' => $product->title,
                        'slug' => $product->slug,
                        'sizes' => $product->sizes,
                        'description' => $product->description,
                        'text' => $product->text,
                        'path_image' => $product->path_image,
                        'path_file' => $product->path_file,
                        'active' => $product->active,
                        'sorting' => $product->sorting,
                        'event' => 'multiple_deleted',
                    ],
                ])
                ->log('multiple_deleted');

            $files[] = $product->path_image;
            $files[] = $product->path_file;
        }

        $deleted = DB::transaction(function () use ($ids) {
            return Product::whereIn('id', $ids)->delete();
        });

        $this->deleteOldFiles($files);

        return [
            'deleted' => $deleted,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Ordenação
    |--------------------------------------------------------------------------
    */

    public function sorting(Request $request): array
    {
        foreach ($request->arrId as $sorting => $id) {
            $product = Product::find($id);

            if ($product) {
                $product->sorting = $sorting;
                $product->save();

                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($product)
                    ->event('order_updated')
                    ->withProperties([
                        'attributes' => [
                            'id' => $id,
                            'title' => $product->title,
                            'slug' => $product->slug,
                            'sizes' => $product->sizes,
                            'description' => $product->description,
                            'text' => $product->text,
                            'path_image' => $product->path_image,
                            'active' => $product->active,
                            'sorting' => $product->sorting,
                            'event' => 'order_updated',
                        ],
                    ])
                    ->log('order_updated');
            } else {
                Log::warning("Item com ID {$id} não encontrado.");
            }
        }

        return [
            'status' => 'success',
        ];
    }
}
