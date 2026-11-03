<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\Product;
use App\Models\SeoGoogle;
use App\Models\Slide;
use App\Models\TemplateTheme;
use App\Models\Topic;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Spatie\Multitenancy\Models\Tenant;

class SeoGoogleController extends Controller
{
    public function __construct(
        protected ThemeManager $themeManager
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ThemeManager $themeManager)
    {
        $tenant = Tenant::current();

        $seoGoogle = SeoGoogle::where('tenant_id', $tenant->id)->first();

        $theme = $themeManager;
        $themeData = $themeManager->theme();

        return view(
            'admin.blades.seo.index',
            compact('seoGoogle', 'theme', 'themeData')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ThemeManager $themeManager)
    {
        $tenant = Tenant::current();

        if (SeoGoogle::where('tenant_id', $tenant->id)->exists()) {
            return redirect()
                ->route('admin.dashboard.seoGoogle.index')
                ->with('warning', 'O SEO deste site já está cadastrado.');
        }

        $theme = $themeManager;
        $themeData = $themeManager->theme();

        return view(
            'admin.blades.seo.create',
            compact('theme', 'themeData')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tenant = Tenant::current();

        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'keywords' => ['nullable', 'string'],
            'social_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:5120'],
            'favicon' => ['nullable', 'image', 'mimes:png,ico,jpg,jpeg,webp', 'max:2048'],
            'organization_name' => ['nullable', 'string', 'max:255'],
            'legal_name' => ['nullable', 'string', 'max:255'],
            'organization_url' => ['nullable', 'url', 'max:255'],
            'organization_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:5120'],
            'organization_description' => ['nullable', 'string'],
            'founding_date' => ['nullable', 'date'],
            'email' => ['nullable', 'email', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:50'],
            'street_address' => ['nullable', 'string', 'max:255'],
            'address_locality' => ['nullable', 'string', 'max:255'],
            'address_region' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'address_country' => ['nullable', 'string', 'max:10'],
            'contact_type' => ['nullable', 'string', 'max:255'],
            'area_served' => ['nullable', 'string', 'max:255'],
            'available_languages' => ['nullable', 'string'],
            'opening_hours' => ['nullable', 'string'],
            'slogan' => ['nullable', 'string', 'max:255'],
            'organization_keywords' => ['nullable', 'string'],
            'search_console' => ['nullable', 'string', 'max:255'],
            'google_tag_manager' => ['nullable', 'string', 'max:50'],
            'google_ads' => ['nullable', 'string', 'max:50'],
            'meta_pixel' => ['nullable', 'string', 'max:50'],
        ]);

        if (SeoGoogle::where('tenant_id', $tenant->id)->exists()) {
            return redirect()
                ->route('admin.dashboard.seoGoogle.index')
                ->with('warning', 'O SEO deste site já está cadastrado.');
        }

        $validated['tenant_id'] = $tenant->id;

        /*
        |--------------------------------------------------------------------------
        | Idiomas
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['available_languages'])) {
            $validated['available_languages'] = collect(
                explode(',', $validated['available_languages'])
            )
                ->map(fn ($language) => trim($language))
                ->filter()
                ->values()
                ->toArray();
        } else {
            $validated['available_languages'] = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Horários
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['opening_hours'])) {
            $openingHours = json_decode(
                $validated['opening_hours'],
                true
            );

            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'opening_hours' => 'O horário de funcionamento possui um JSON inválido.'
                    ]);
            }

            $validated['opening_hours'] = $openingHours;
        } else {
            $validated['opening_hours'] = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Imagem social
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('social_image')) {
            $validated['social_image'] = $request
                ->file('social_image')
                ->store('seo/social', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Favicon
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('favicon')) {
            $validated['favicon'] = $request
                ->file('favicon')
                ->store('seo/favicon', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Logo da organização
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('organization_logo')) {
            $validated['organization_logo'] = $request
                ->file('organization_logo')
                ->store('seo/organization', 'public');
        }

        SeoGoogle::create($validated);

        return redirect()
            ->route('admin.dashboard.seoGoogle.index')
            ->with('success', 'Configurações de SEO cadastradas com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SeoGoogle $seoGoogle)
    {
        $this->authorizeTenant($seoGoogle);

        return view(
            'admin.blades.seo.show',
            compact('seoGoogle')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        SeoGoogle $seoGoogle,
        ThemeManager $themeManager
    ) {
        $this->authorizeTenant($seoGoogle);

        $theme = $themeManager;
        $themeData = $themeManager->theme();

        return view(
            'admin.blades.seo.edit',
            compact('seoGoogle', 'theme', 'themeData')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        SeoGoogle $seoGoogle
    ) {
        $this->authorizeTenant($seoGoogle);

        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'keywords' => ['nullable', 'string'],
            'social_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:5120'],
            'favicon' => ['nullable', 'image', 'mimes:png,ico,jpg,jpeg,webp', 'max:2048'],
            'organization_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:5120'],
            'organization_name' => ['nullable', 'string', 'max:255'],
            'legal_name' => ['nullable', 'string', 'max:255'],
            'organization_url' => ['nullable', 'url', 'max:255'],
            'organization_description' => ['nullable', 'string'],
            'founding_date' => ['nullable', 'date'],
            'email' => ['nullable', 'email', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:50'],
            'street_address' => ['nullable', 'string', 'max:255'],
            'address_locality' => ['nullable', 'string', 'max:255'],
            'address_region' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'address_country' => ['nullable', 'string', 'max:10'],
            'contact_type' => ['nullable', 'string', 'max:255'],
            'area_served' => ['nullable', 'string', 'max:255'],
            'available_languages' => ['nullable', 'string'],
            'opening_hours' => ['nullable', 'string'],
            'slogan' => ['nullable', 'string', 'max:255'],
            'organization_keywords' => ['nullable', 'string'],
            'search_console' => ['nullable', 'string', 'max:255'],
            'google_tag_manager' => ['nullable', 'string', 'max:50'],
            'google_ads' => ['nullable', 'string', 'max:50'],
            'meta_pixel' => ['nullable', 'string', 'max:50'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Idiomas
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['available_languages'])) {
            $validated['available_languages'] = collect(
                explode(',', $validated['available_languages'])
            )
                ->map(fn ($language) => trim($language))
                ->filter()
                ->values()
                ->toArray();
        } else {
            $validated['available_languages'] = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Horários
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['opening_hours'])) {
            $openingHours = json_decode(
                $validated['opening_hours'],
                true
            );

            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'opening_hours' => 'O horário de funcionamento possui um JSON inválido.'
                    ]);
            }

            $validated['opening_hours'] = $openingHours;
        } else {
            $validated['opening_hours'] = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Nova imagem social
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('social_image')) {
            if (
                $seoGoogle->social_image &&
                Storage::disk('public')->exists($seoGoogle->social_image)
            ) {
                Storage::disk('public')->delete($seoGoogle->social_image);
            }

            $validated['social_image'] = $request
                ->file('social_image')
                ->store('seo/social', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Novo favicon
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('favicon')) {
            if (
                $seoGoogle->favicon &&
                Storage::disk('public')->exists($seoGoogle->favicon)
            ) {
                Storage::disk('public')->delete($seoGoogle->favicon);
            }

            $validated['favicon'] = $request
                ->file('favicon')
                ->store('seo/favicon', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Nova logo da organização
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('organization_logo')) {
            if (
                $seoGoogle->organization_logo &&
                Storage::disk('public')->exists($seoGoogle->organization_logo)
            ) {
                Storage::disk('public')->delete($seoGoogle->organization_logo);
            }

            $validated['organization_logo'] = $request
                ->file('organization_logo')
                ->store('seo/organization', 'public');
        }

        $seoGoogle->update($validated);

        return redirect()
            ->route('admin.dashboard.seoGoogle.index')
            ->with('success', 'Configurações de SEO atualizadas com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SeoGoogle $seoGoogle)
    {
        $this->authorizeTenant($seoGoogle);

        $disk = Storage::disk('public');

        if (
            $seoGoogle->social_image &&
            $disk->exists($seoGoogle->social_image)
        ) {
            $disk->delete($seoGoogle->social_image);
        }

        if (
            $seoGoogle->favicon &&
            $disk->exists($seoGoogle->favicon)
        ) {
            $disk->delete($seoGoogle->favicon);
        }

        if (
            $seoGoogle->organization_logo &&
            $disk->exists($seoGoogle->organization_logo)
        ) {
            $disk->delete($seoGoogle->organization_logo);
        }

        $seoGoogle->delete();

        return redirect()
            ->route('admin.dashboard.seoGoogle.index')
            ->with('success', 'Configurações de SEO removidas com sucesso.');
    }

    /**
     * Garante que o registro pertence ao tenant atual.
     */
    private function authorizeTenant(SeoGoogle $seoGoogle): void
    {
        $tenant = Tenant::current();

        abort_unless(
            $tenant && $seoGoogle->tenant_id === $tenant->id,
            403
        );
    }

    /**
     * Robots.txt dinâmico por tenant.
     */
    public function robots(): Response
    {
        $tenant = Tenant::current();

        if (!$tenant) {
            abort(404);
        }

        $content = "User-agent: *\n";
        $content .= "Allow: /\n\n";
        $content .= "Disallow: /admin\n";
        $content .= "Disallow: /login.do\n";
        $content .= "Disallow: /logout\n";
        $content .= "Disallow: /client/\n";
        $content .= "Disallow: /api/\n";
        $content .= "Disallow: /password/\n";
        $content .= "Disallow: /cliente/cadastro\n";
        $content .= "Disallow: /send-contact\n";
        $content .= "Disallow: /send-newsletter\n";
        $content .= "Disallow: /blog/search\n";
        $content .= "Disallow: /download-ficha/store\n";
        $content .= "\n";
        $content .= "Sitemap: " . url('/sitemap.xml') . "\n";

        return response($content, 200)
            ->header('Content-Type', 'text/plain; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    /**
     * Sitemap.xml dinâmico por tenant.
     */
    public function sitemap(): Response
    {
        $tenant = Tenant::current();

        if (!$tenant) {
            abort(404);
        }

        $urls = [];

        /*
        |--------------------------------------------------------------------------
        | HOME
        |--------------------------------------------------------------------------
        */

        $homeModules = [
            'slides',
            'topics',
            'statute',
            'letsgo',
            'faq_session',
            'faq',
            'testimonials',
            'services',
            'about',
            'benefits',
            'mission',
            'representatives',
            'videos',
            'service_locations',
            'contact',
            'contact_leads',
            'download_leads',
            'blog',
            'products',
            'privacy_police',
            'user_term',
        ];

        $urls[] = $this->makeUrl(
            url('/'),
            $this->latestUpdatedAt($homeModules)
        );

        /*
        |--------------------------------------------------------------------------
        | ONEPAGE
        |--------------------------------------------------------------------------
        |
        | No Onepage, todas as seções pertencem à home.
        |
        | Portanto, não criamos URLs independentes para:
        |
        | /sobre
        | /contato
        | /blog
        | /produtos
        |
        */

        if ($this->themeManager->layoutType() === 'onepage') {
            return $this->renderSitemap(
                collect($urls)->unique('loc')->values()->all()
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SOBRE
        |--------------------------------------------------------------------------
        |
        | IMPORTANTE:
        |
        | Usamos hasPage() e não hasModule().
        |
        | Se o template tiver:
        |
        | 'about' => [
        |     'about',
        |     'benefits',
        |     ...
        | ]
        |
        | então /sobre existe.
        |
        | Se tiver:
        |
        | 'home' => [
        |     'about',
        |     ...
        | ]
        |
        | mas não tiver a chave 'about', então /sobre NÃO existe.
        |
        */

        if ($this->themeManager->hasPage('about')) {
            $about = About::query()
                ->active()
                ->latest('updated_at')
                ->first();

            if ($about) {
                $urls[] = $this->makeUrl(
                    url('/sobre'),
                    $about->updated_at
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | CONTATO
        |--------------------------------------------------------------------------
        |
        | Só cria /contato se "contact" for uma página real
        | no template atual.
        |
        */

        if ($this->themeManager->hasPage('contact')) {
            $contact = Contact::query()
                ->latest('updated_at')
                ->first();

            if ($contact) {
                $urls[] = $this->makeUrl(
                    url('/contato'),
                    $contact->updated_at
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | BLOG
        |--------------------------------------------------------------------------
        |
        | Só cria /blog se "blog" for uma página real
        | no template atual.
        |
        */

        if ($this->themeManager->hasPage('blog')) {
            $this->addBlogUrls($urls);
        }

        /*
        |--------------------------------------------------------------------------
        | PRODUTOS
        |--------------------------------------------------------------------------
        |
        | Só cria /produtos se "products" for uma página real
        | no template atual.
        |
        */

        if ($this->themeManager->hasPage('products')) {
            $this->addProductUrls($urls);
        }

        /*
        |--------------------------------------------------------------------------
        | TEMPLATES
        |--------------------------------------------------------------------------
        |
        | Só cria /templates se "templates" for uma página real
        | no template atual.
        |
        */

        
        if ($this->themeManager->hasPage('templates')) {
            $this->addTemplatesUrls($urls);
        }

        if ($this->themeManager->hasPage('about_static')) {
            $this->addAboutStaticUrls($urls);
        }

        if ($this->themeManager->hasPage('privacy_police')) {
            $this->addPrivacyPoliceUrls($urls);
        }

        if ($this->themeManager->hasPage('use_term')) {
            $this->addUseTermUrls($urls);
        }

        /*
        |--------------------------------------------------------------------------
        | REMOVE DUPLICADAS
        |--------------------------------------------------------------------------
        */

        $urls = collect($urls)
            ->unique('loc')
            ->values()
            ->all();

        return $this->renderSitemap($urls);
    }

    protected function addTemplatesUrls(array &$urls): void
    {
        $templates = TemplateTheme::query()
            ->where('active', 1)
            ->latest('updated_at')
            ->get();

        if ($templates->isEmpty()) {
            return;
        }

        $urls[] = $this->makeUrl(
            url('/templates'),
            $templates->first()->updated_at
        );

        foreach ($templates as $template) {
            if (!$template->slug) {
                continue;
            }

            $urls[] = $this->makeUrl(
                url('/template/' . $template->slug . '/' . $template->template_variation),
                $template->updated_at
            );
        }
    }

    protected function addAboutStaticUrls(array &$urls): void
    {
        $urls[] = $this->makeUrl(
            url('/sobre-nos')
        );
    }

    protected function addUseTermUrls(array &$urls): void
    {
        $urls[] = $this->makeUrl(
            url('/termos-de-uso')
        );
    }
    protected function addPrivacyPoliceUrls(array &$urls): void
    {
        $urls[] = $this->makeUrl(
            url('/politica-de-privacidade')
        );
    }

    /**
     * Adiciona URLs do blog.
     */
    protected function addBlogUrls(array &$urls): void
    {
        $blogs = Blog::query()
            ->active()
            ->latest('updated_at')
            ->get();

        if ($blogs->isEmpty()) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Página principal do blog
        |--------------------------------------------------------------------------
        */

        $urls[] = $this->makeUrl(
            url('/blog'),
            $blogs->first()->updated_at
        );

        /*
        |--------------------------------------------------------------------------
        | Artigos
        |--------------------------------------------------------------------------
        */

        foreach ($blogs as $blog) {
            if (!$blog->slug) {
                continue;
            }

            $urls[] = $this->makeUrl(
                url('/blog/' . $blog->slug),
                $blog->updated_at
            );
        }
    }

    /**
     * Adiciona URLs dos produtos.
     */
    protected function addProductUrls(array &$urls): void
    {
        $products = Product::query()
            ->where('active', 1)
            ->with('category')
            ->latest('updated_at')
            ->get();

        if ($products->isEmpty()) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Página principal dos produtos
        |--------------------------------------------------------------------------
        */

        $urls[] = $this->makeUrl(
            url('/produtos'),
            $products->first()->updated_at
        );

        /*
        |--------------------------------------------------------------------------
        | Produtos individuais
        |--------------------------------------------------------------------------
        */

        foreach ($products as $product) {
            if (!$product->slug) {
                continue;
            }

            if (!$product->category || !$product->category->slug) {
                continue;
            }

            $urls[] = $this->makeUrl(
                url('/produto/' . $product->category->slug . '/' . $product->slug),
                $product->updated_at
            );
        }
    }

    /**
     * Cria estrutura de URL.
     */
    protected function makeUrl(string $url, $lastmod = null): array
    {
        return [
            'loc' => $url,
            'lastmod' => $lastmod?->toAtomString(),
        ];
    }

    /**
     * Retorna a data mais recente entre os módulos informados.
     *
     * Usada para definir o lastmod da home.
     */
    protected function latestUpdatedAt(array $modules)
    {
        $dates = collect();

        foreach ($modules as $module) {
            if (!$this->themeManager->hasModule($module)) {
                continue;
            }

            switch ($module) {
                case 'slides':
                    $date = Slide::query()
                        ->latest('updated_at')
                        ->value('updated_at');
                    break;

                case 'topics':
                    $date = Topic::query()
                        ->latest('updated_at')
                        ->value('updated_at');
                    break;

                case 'about':
                    $date = About::query()
                        ->active()
                        ->latest('updated_at')
                        ->value('updated_at');
                    break;

                case 'contact':
                    $date = Contact::query()
                        ->latest('updated_at')
                        ->value('updated_at');
                    break;

                case 'blog':
                    $date = Blog::query()
                        ->active()
                        ->latest('updated_at')
                        ->value('updated_at');
                    break;

                case 'products':
                    $date = Product::query()
                        ->where('active', 1)
                        ->latest('updated_at')
                        ->value('updated_at');
                    break;

                default:
                    $date = null;
                    break;
            }

            if ($date) {
                $dates->push($date);
            }
        }

        return $dates->sortDesc()->first() ?? now();
    }

    /**
     * Renderiza o sitemap.
     */
    protected function renderSitemap(array $urls): Response
    {
        $xml = view(
            'client.script-seo-google.sitemap',
            compact('urls')
        )->render();

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }
}