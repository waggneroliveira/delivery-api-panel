<?php

use App\Http\Controllers\Auth\AuthClientController;
use App\Http\Controllers\Auth\PasswordEmailClientController;
use App\Http\Controllers\Auth\ResetPasswordClientController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DownloadFichaController;
use App\Http\Controllers\FormIndexController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\SeoGoogleController;
use App\Http\Middleware\AuthClientMiddleware;
use App\Http\Middleware\NeedsTenant;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\SeoGoogle;
use App\Models\TemplateTheme;
use App\Modules\Client\Presentation\Controllers\AboutPageController;
use App\Modules\Client\Presentation\Controllers\BlogPageController;
use App\Modules\Client\Presentation\Controllers\ClientController;
use App\Modules\Client\Presentation\Controllers\ContactPageController;
use App\Modules\Client\Presentation\Controllers\DocumentationController;
use App\Modules\Client\Presentation\Controllers\EventPageController;
use App\Modules\Client\Presentation\Controllers\HomePageController;
use App\Modules\Client\Presentation\Controllers\ProductPageController;
use App\Modules\Client\Presentation\Controllers\TemplatePageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

require __DIR__ . '/dashboard.php';

// =============================
// Rotas que NÃO precisam tenant
// =============================

// =============================
// Rotas dos clientes/tenants
// =============================

Route::middleware([NeedsTenant::class])->group(function () {

    Route::get('/', [HomePageController::class, 'index'])
        ->name('index');

    Route::get('templates', [TemplatePageController::class, 'templateAll'])
        ->name('templates');

    Route::get('template/{slug}/{templateVariation?}', [TemplatePageController::class, 'templateInner'])
        ->name('template');

    Route::get('/produto', function () {
            return view('client.themes.ecommerce.tp-01.blades.product');
        })->name('prod');

    Route::get('produto/{category}/{slug}', [ProductPageController::class, 'productView'])
        ->name('client.product');


    Route::get('produtos', [ProductPageController::class, 'productAll'])
        ->name('products');


    Route::post('login.do', [AuthClientController::class, 'authenticate'])
        ->name('client.user.authenticate');


    Route::post('/password/email', [PasswordEmailClientController::class, 'passwordEmail'])
        ->name('client.password.email');


    Route::get('/email-enviado-com-sucesso', [PasswordEmailClientController::class, 'showSuccess'])
        ->name('send-success-client');


    Route::post('/password/reset', [ResetPasswordClientController::class, 'processPasswordReset'])
        ->name('client-password.update');


    Route::get('password/reset/{token}', [ResetPasswordClientController::class, 'showResetForm'])
        ->name('client.password.reset');


    Route::get('/senha-alterada-com-sucesso', function () {
        return view('emails.password-success-client-reset');
    })->name('client-success-reset-password');


    Route::middleware([AuthClientMiddleware::class])->group(function () {

        Route::put('/client/update', [ClientController::class, 'update'])
            ->name('client.update');


        Route::post('/client/comments', [CommentController::class, 'store'])
            ->name('blog.comment');


        Route::get('logout', [AuthClientController::class, 'logout'])
            ->name('client.user.logout');

    });


    Route::get('imovel', function () {
        return view('client.themes.corretora.tp-01.blades.imovel');
    })->name('imovel');

    Route::get('politica-de-privacidade', [HomePageController::class, 'policePrivacy'])
        ->name('privacy-police');

    Route::get('termos-de-uso', [HomePageController::class, 'useTerm'])
        ->name('use-term');

    Route::get('contato', [ContactPageController::class, 'index'])
        ->name('contact');


    Route::post('send-contact', [FormIndexController::class, 'store'])
        ->name('send-contact');


    Route::get('blog/filter', [HomePageController::class, 'filterBySubCategory'])
        ->name('blog.filter.subcategory');


    Route::get('blog/{slug}', [BlogPageController::class, 'blogInner'])
        ->name('blog-inner');


    Route::get('blog', [BlogPageController::class, 'index'])
        ->name('blogAll');


    Route::get('blog/categoria/{category?}', [BlogPageController::class, 'index'])
        ->name('blog');


    Route::post('blog/search', [BlogPageController::class, 'index'])
        ->name('blog-search');


    Route::post('send-newsletter', [NewsletterController::class, 'store'])
        ->name('send-newsletter');


    Route::post('cliente/cadastro', [ClientController::class, 'store'])
        ->name('register-client');


    Route::get('sobre', [AboutPageController::class, 'index'])
        ->name('about');


    Route::get('eventos', [EventPageController::class, 'index'])
        ->name('client.event');

    Route::get('client-documentation', [DocumentationController::class, 'index'])
        ->name('client.documentation');

    // Route::get('blog/filter/{category?}', [HomePageController::class, 'filterByCategory'])
    //     ->name('blog.filter');

    Route::post('/download-ficha/store', [DownloadFichaController::class, 'store'])
        ->name('download.ficha.store');

    Route::get('planos/categoria/{id}', [HomePageController::class, 'getPlansByCategory']);

    Route::get('/robots.txt', [SeoGoogleController::class, 'robots'])->name('seo.robots');
    Route::get('/sitemap.xml', [SeoGoogleController::class, 'sitemap'])->name('seo.sitemap');
});

// =============================
// View Composer
// =============================

View::composer('client.themes.blog.tp-01.core.client', function ($view) {
    $contact = Contact::first();
    $blogInner = Blog::with('category')->where('slug', request()->route('slug'))->first();
    $templateThemeInner = TemplateTheme::where('slug', request()->route('slug'))
    ->when(request()->route('templateVariation'), fn ($query) => $query->where('template_variation', request()->route('templateVariation')))
    ->active()
    ->first();

    $seoGoogle = SeoGoogle::first();
    
    return $view->with([
        'contact' => $contact,
        'seoGoogle' => $seoGoogle,
        'blogInner' => $blogInner,
        'templateThemeInner' => $templateThemeInner,
    ]);

});