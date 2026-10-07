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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\ImageManager;

class ProductService
{
    protected function getPathUpload(): string
    {
        $themeManager = app(ThemeManager::class);

        $template = $themeManager->current() ?? 'default';
        $variation = $themeManager->variation() ?? 'default';

        return "admin/uploads/images/templates/{$template}/{$variation}/product/";
    }

    public function getIndexData(Request $request, ThemeManager $themeManager): array
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();
        $check = checkPermission('products', 'produtos.visualizar', $settingTheme);
        if ($check !== true) {
            return ['forbidden' => $check];
        }
        $serviceSection = ServiceSection::whereIn('section', ['product'])
        ->get()
        ->keyBy('section');

        $categories = ProductCategory::active()->sorting()->get();
        $productsQuery = Product::with(['category']);

        if ($request->filled('title')) {
            $productsQuery->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('product_category_id')) {
            $productsQuery->where('product_category_id', $request->product_category_id);
        }

        $products = $productsQuery->sorting()->paginate(60)->withQueryString();
        $productCategory = [];
        foreach ($categories as $category) {
            $productCategory[$category->id] = $category->title;
        }
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        return compact('products', 'categories', 'productCategory', 'theme', 'themeData', 'settingTheme', 'serviceSection');
    }

    public function getCreateData(ThemeManager $themeManager): array
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->hasRole('Super') && !$user->can('usuario.tornar usuario master') && !($user->hasPermissionTo('produtos.visualizar') && $user->hasPermissionTo('produtos.criar'))) {
            return ['forbidden' => view('admin.error.403', compact('settingTheme'))];
        }

        $categories = ProductCategory::active()->sorting()->get();
        $brands = Brand::active()->sorting()->get();
        $productCategory = [];
        foreach ($categories as $category) {
            $productCategory[$category->id] = $category->title;
        }
        $productBrand = [];
        foreach ($brands as $brand) {
            $productBrand[$brand->id] = $brand->title;
        }
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        return compact('categories', 'productCategory', 'productBrand', 'theme', 'themeData');
    }

    public function getEditData(Product $product, ThemeManager $themeManager): array
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->hasRole('Super') && !$user->can('usuario.tornar usuario master') && !($user->hasPermissionTo('produtos.visualizar') && $user->hasPermissionTo('produtos.editar'))) {
            return ['forbidden' => view('admin.error.403', compact('settingTheme'))];
        }

        $product = $product->with(['galleries' => function ($query) {
            $query->orderBy('sorting', 'ASC');
        }])->find($product->id);

        $categories = ProductCategory::active()->sorting()->get();
        $brands = Brand::active()->sorting()->get();
        $productCategory = [];
        foreach ($categories as $category) {
            $productCategory[$category->id] = $category->title;
        }
        $productBrand = [];
        foreach ($brands as $brand) {
            $productBrand[$brand->id] = $brand->title;
        }
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        return compact('product', 'categories', 'productCategory', 'productBrand', 'theme', 'themeData');
    }

    public function store(ProductStoreRequest $request): Product
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;
        $data['slug'] = Str::slug($request->title);

        // Formata o campo price
        $valorFormatado = $request->price;

        $valorNumerico = str_replace(
            ['R$', ' ', "\u{A0}"],
            '',
            $valorFormatado
        );

        $valorNumerico = str_replace(',', '.', $valorNumerico);

        $data['price'] = floatval($valorNumerico);

        // Sizes
        if (isset($data['sizes'])) {
            $sizes = array_values(
                array_filter(
                    $request->sizes,
                    function ($size) {
                        return !is_null($size) && trim($size) !== '';
                    }
                )
            );

            $data['sizes'] = !empty($sizes)
                ? json_encode($sizes)
                : json_encode([]);
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
            $file = $request->file('path_image');
            $mime = $file->getMimeType();

            if ($mime === 'image/svg+xml') {
                $filename = Str::uuid() . '.svg';

                Storage::disk('public')->putFileAs(
                    $pathUpload,
                    $file,
                    $filename
                );
            } else {
                $filename = Str::uuid() . '.avif';

                $image = $manager
                    ->read($file)
                    ->toAvif(quality: 90)
                    ->toString();

                Storage::disk('public')->put(
                    $pathUpload . $filename,
                    $image
                );
            }

            $data['path_image'] = $pathUpload . $filename;
        }

        /*
        |--------------------------------------------------------------------------
        | Arquivo / imagem
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('path_file')) {
            $file = $request->file('path_file');
            $mime = $file->getMimeType();

            // SVG
            if ($mime === 'image/svg+xml') {
                $filename = Str::uuid() . '.svg';

                Storage::disk('public')->putFileAs(
                    $pathUpload,
                    $file,
                    $filename
                );
            }
            // Qualquer imagem
            elseif (str_starts_with($mime, 'image/')) {
                $filename = Str::uuid() . '.avif';

                $image = $manager
                    ->read($file)
                    ->toAvif(quality: 90)
                    ->toString();

                Storage::disk('public')->put(
                    $pathUpload . $filename,
                    $image
                );
            }
            // Outros arquivos
            else {
                $extension = $file->getClientOriginalExtension();
                $filename = Str::uuid() . '.' . $extension;

                Storage::disk('public')->putFileAs(
                    $pathUpload,
                    $file,
                    $filename
                );
            }

            $data['path_file'] = $pathUpload . $filename;
        }

        DB::beginTransaction();

        try {
            $product = Product::create($data);

            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    public function uploadImageCkeditor(Request $request): array
    {
        if (!$request->hasFile('upload')) {
        return [
            'uploaded' => 0,
            'error' => ['message' => 'Upload falhou.'],
        ];
        }

        $file = $request->file('upload');

        $mime = $file->getMimeType();

        $pathUpload = $this->getPathUpload();

        $manager = new ImageManager(new ImagickDriver());

        if ($mime === 'image/svg+xml') {

            $filename = Str::uuid() . '.svg';

            Storage::disk('public')->putFileAs(
                $pathUpload,
                $file,
                $filename
            );

        } else {

            $filename = Str::uuid() . '.avif';

            $image = $manager
                ->read($file)
                ->toAvif(quality: 90)
                ->toString();

            Storage::disk('public')->put(
                $pathUpload . $filename,
                $image
            );
        }

        return [
            'uploaded' => 1,

            'fileName' => $filename,

            'url' => asset(
                'storage/' . $pathUpload . $filename
            ),
        ];

    }

    public function update(ProductUpdateRequest $request, Product $product): Product
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;
        $data['slug'] = Str::slug($request->title);

        // Formata o campo price
        $valorFormatado = $request->price;

        $valorNumerico = str_replace(
            ['R$', ' ', "\u{A0}"],
            '',
            $valorFormatado
        );

        $valorNumerico = str_replace(',', '.', $valorNumerico);

        $data['price'] = floatval($valorNumerico);

        // Sizes
        if (isset($data['sizes'])) {
            $sizes = array_values(
                array_filter(
                    $request->sizes,
                    function ($size) {
                        return !is_null($size) && trim($size) !== '';
                    }
                )
            );

            $data['sizes'] = !empty($sizes)
                ? json_encode($sizes)
                : json_encode([]);
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
            $file = $request->file('path_image');
            $mime = $file->getMimeType();

            if ($mime === 'image/svg+xml') {
                $filename = Str::uuid() . '.svg';

                Storage::disk('public')->putFileAs(
                    $pathUpload,
                    $file,
                    $filename
                );
            } else {
                $filename = Str::uuid() . '.avif';

                $image = $manager
                    ->read($file)
                    ->toAvif(quality: 90)
                    ->toString();

                Storage::disk('public')->put(
                    $pathUpload . $filename,
                    $image
                );
            }

            if (!empty($product->path_image)) {
                Storage::disk('public')->delete(
                    $product->path_image
                );
            }

            $data['path_image'] = $pathUpload . $filename;
        }

        /*
        |--------------------------------------------------------------------------
        | Remover imagem do produto
        |--------------------------------------------------------------------------
        */
        if (
            $request->has('delete_path_image') &&
            !$request->hasFile('path_image')
        ) {
            if (!empty($product->path_image)) {
                Storage::disk('public')->delete(
                    $product->path_image
                );
            }

            $data['path_image'] = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Arquivo / imagem
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('path_file')) {
            $file = $request->file('path_file');
            $mime = $file->getMimeType();

            /*
            * Se for SVG, mantém SVG.
            */
            if ($mime === 'image/svg+xml') {
                $filename = Str::uuid() . '.svg';

                Storage::disk('public')->putFileAs(
                    $pathUpload,
                    $file,
                    $filename
                );
            }
            /*
            * Se for imagem, converte para AVIF.
            */
            elseif (str_starts_with($mime, 'image/')) {
                $filename = Str::uuid() . '.avif';

                $image = $manager
                    ->read($file)
                    ->toAvif(quality: 90)
                    ->toString();

                Storage::disk('public')->put(
                    $pathUpload . $filename,
                    $image
                );
            }
            /*
            * Se não for imagem, mantém o arquivo original.
            */
            else {
                $extension = $file->getClientOriginalExtension();
                $filename = Str::uuid() . '.' . $extension;

                Storage::disk('public')->putFileAs(
                    $pathUpload,
                    $file,
                    $filename
                );
            }

            // Remove arquivo anterior
            if (!empty($product->path_file)) {
                Storage::disk('public')->delete(
                    $product->path_file
                );
            }

            $data['path_file'] = $pathUpload . $filename;
        }

        /*
        |--------------------------------------------------------------------------
        | Remover arquivo / imagem
        |--------------------------------------------------------------------------
        */
        if (
            $request->has('delete_path_file') &&
            !$request->hasFile('path_file')
        ) {
            if (!empty($product->path_file)) {
                Storage::disk('public')->delete(
                    $product->path_file
                );
            }

            $data['path_file'] = null;
        }

        DB::beginTransaction();

        try {
            $product->fill($data)->save();

            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    public function delete(Product $product): void
    {
        Storage::delete($product->path_image ?? '');
        Storage::delete($product->path_file ?? '');
        $product->delete();
    }

    public function destroySelected(Request $request): array
    {
        foreach ($request->deleteAll as $productId) {
            $product = Product::find($productId);

            if ($product) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($product)
                    ->event('multiple_deleted')
                    ->withProperties([
                        'attributes' => [
                            'id' => $productId,
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
            } else {
                Log::warning("Item com ID {$productId} não encontrado.");
            }
        }

        $deleted = Product::whereIn('id', $request->deleteAll)->delete();

        return ['deleted' => $deleted];
    }

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

        return ['status' => 'success'];
    }
}
