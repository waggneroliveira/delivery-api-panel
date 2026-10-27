<?php

namespace App\Providers;

use App\Models\AdSlot;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\SeoGoogle;
use App\Models\TemplateTheme;
use App\Models\Tenant;
use App\Modules\Client\Contracts\ClientRepositoryInterface;
use App\Modules\Client\Data\EloquentClientRepository;
use App\Services\ThemeManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ClientRepositoryInterface::class, EloquentClientRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    // public function boot(): void
    // {
    //     Carbon::setLocale('pt_BR');

    //     View::composer('client.themes.*.*.core.*', function ($view) {
    //         $view->with('seoGoogle', SeoGoogle::first());
    //     });
    // }


    public function boot(): void
    {
        Carbon::setLocale('pt_BR');

        View::composer('client.themes.*.*.core.*', function ($view) {
            $blogInner = null;

            if (request()->routeIs('blog')) {
                $blogInner = Blog::with('category')
                    ->where('slug', request()->route('slug'))
                    ->first();
            }
            $templateThemeInner = TemplateTheme::where('slug', request()->route('slug'))
            ->when(request()->route('templateVariation'), fn ($query) => $query->where('template_variation', request()->route('templateVariation')))
            ->active()
            ->first();
            $tenantTheme = Tenant::current();

            $themeManager = new ThemeManager();
            
            $themeData = $themeManager?->theme();

            $adSlots = collect();

            if ($themeData) {
                $adSlots = AdSlot::query()
                    ->where('template_theme_id', $themeData->id)
                    ->where('active', true)
                    ->with([
                        'announcements' => function ($query) use ($tenantTheme) {
                            $query
                                ->where('active', true)
                                ->whereIn('display_location', ['web', 'both'])
                                ->where(function ($query) use ($tenantTheme) {
                                    $query
                                        ->where('target', 'all')
                                        ->orWhere(function ($query) use ($tenantTheme) {
                                            $query
                                                ->where('target', 'specific')
                                                ->whereHas('tenants', function ($query) use ($tenantTheme) {
                                                    $query->where('tenants.id', $tenantTheme->id);
                                                });
                                        });
                                })
                                ->where(function ($query) {
                                    $query
                                        ->whereNull('starts_at')
                                        ->orWhere('starts_at', '<=', now());
                                })
                                ->where(function ($query) {
                                    $query
                                        ->whereNull('ends_at')
                                        ->orWhere('ends_at', '>=', now());
                                })
                                ->latest();
                        },
                    ])
                    ->orderBy('sorting')
                    ->orderBy('name')
                    ->get();
            }

            $announcements = $adSlots->mapWithKeys(function ($adSlot) {
                return [
                    $adSlot->slug => $adSlot->announcements,
                ];
            });
            
            $blogCategoriesHeader = BlogCategory::with([
                'subcategories' => function ($query) {
                    $query->active()
                        ->with([
                            'blogs' => function ($query) {
                                $query->active()
                                    ->orderByDesc('date')
                                    ->orderByDesc('id')
                                    ->limit(4);
                            }
                        ])
                        ->orderBy('name');
                },
                'blogs' => function ($query) {
                    $query->active()
                        ->orderByDesc('date')
                        ->orderByDesc('id')
                        ->limit(5);
                }
            ])
            ->where('show_in_header', 1)
            ->active()
            ->sorting()
            ->where(function ($query) {
                $query->whereHas('blogs', function ($blogs) {
                    $blogs->active();
                })->orWhereHas('subcategories.blogs', function ($blogs) {
                    $blogs->active();
                });
            })
            ->get();
            
            $view->with([
                'seoGoogle' => SeoGoogle::first(),
                'announcements' => $announcements,
                'blogCategoriesHeader' => $blogCategoriesHeader,
                'blogInner' => $blogInner,
                'templateThemeInner' => $templateThemeInner,
            ]);
        });
    }
}
