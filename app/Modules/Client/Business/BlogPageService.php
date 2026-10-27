<?php

namespace App\Modules\Client\Business;

use App\Models\AdSlot;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Contact;
use App\Models\PopUp;
use App\Models\Tenant;
use App\Services\ThemeManager;
use Illuminate\Http\Request;

class BlogPageService
{
    public function getIndexData(Request $request, $category = null, ThemeManager $themeManager): array
    {
        $tenantTheme = Tenant::current();
        $theme = $themeManager;
        $themeData = $themeManager->theme();

        $search = $request->input('search');
        $blogCategories = BlogCategory::whereHas('blogs')->active()->sorting()->get();

        $blogAll = Blog::with('category')
            ->whereHas('category', function ($active) {
                $active->where('active', 1);
            });

        if ($category) {
            $blogAll = $blogAll->whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category);
            });
        }

        if ($search) {
            $blogAll = $blogAll->whereHas('category')->where('title', 'like', '%' . $search . '%');
        }

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

        $announcements = $adSlots->mapWithKeys(function ($adSlot) {
            return [
                $adSlot->slug => $adSlot->announcements,
            ];
        });

        $blogAll = $blogAll->active()->sorting()->paginate(15);

        $blogSeeAlso = Blog::with('category')
            ->whereHas('category', function ($active) {
                $active->where('active', 1);
            })
            ->whereNotIn('id', $blogAll->pluck('id'))
            ->active()
            ->inRandomOrder()
            ->limit(15)
            ->get();

        $popUp = PopUp::active()->first();

        return compact('announcements', 'blogCategories', 'blogAll', 'blogSeeAlso', 'popUp', 'tenantTheme','theme', 'themeData');
    }

    public function getInnerData($slug = null, ThemeManager $themeManager): array
    {
        $tenantTheme = Tenant::current();
        $theme = $themeManager;
        $themeData = $themeManager->theme();

        if (!$slug) {
            return ['view' => view($theme->error('404'))];
        }

        $blogInner = Blog::with(['category'])
            ->whereHas('category')
            ->where('slug', $slug)
            ->active()
            ->sorting()
            ->first();

        if (!$blogInner) {
            return ['view' => view($theme->error('404'))];
        }

        $blogRelacionados = Blog::whereHas('category', function ($query) use ($blogInner) {
            $query->where('id', $blogInner->category->id);
        })
            ->where('id', '!=', $blogInner->id)
            ->active()
            ->sorting()
            ->take(4)
            ->get();

        $viewMores = Blog::whereHas('category', function ($query) use ($blogInner) {
            $query->where('id', '<>', $blogInner->category->id);
        })
        ->active()
        ->sorting()
        ->get();

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

        $announcements = $adSlots->mapWithKeys(function ($adSlot) {
            return [
                $adSlot->slug => $adSlot->announcements,
            ];
        });

        $contact = Contact::first();

        return compact(
            'contact',
            'viewMores',
            'announcements',
            'blogInner',
            'slug',
            'blogRelacionados', 
            'theme', 
            'themeData',
            'tenantTheme'
        );
    }
}
