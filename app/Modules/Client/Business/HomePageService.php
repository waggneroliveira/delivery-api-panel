<?php

namespace App\Modules\Client\Business;

use App\Models\About;
use App\Models\AdSlot;
use App\Models\Advantage;
use App\Models\Announcement;
use App\Models\BenefitTopic;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogSubcategory;
use App\Models\Contact;
use App\Models\Depoiment;
use App\Models\Direction;
use App\Models\Event;
use App\Models\Faq;
use App\Models\ImpactSection;
use App\Models\Letsgo;
use App\Models\LineOfTime;
use App\Models\Partner;
use App\Models\Plan;
use App\Models\PlanNetwork;
use App\Models\PlanNetworkCategory;
use App\Models\PopUp;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductGallery;
use App\Models\Report;
use App\Models\ServiceItem;
use App\Models\ServiceLocation;
use App\Models\ServiceSection;
use App\Models\SessaoFaq;
use App\Models\Slide;
use App\Models\Statute;
use App\Models\TemplateTheme;
use App\Models\Tenant;
use App\Models\Topic;
use App\Models\Video;
use App\Services\ThemeManager;
use Illuminate\Support\Facades\Request;

class HomePageService
{
    public function getIndexData(ThemeManager $themeManager): array
    {
        $templateThemes = TemplateTheme::active()->get();
        $tenantTheme = Tenant::current();
        $theme = $themeManager;
        $themeData = $themeManager->theme();

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
        
        $slides = Slide::active()->sorting()->get();
        $topics = Topic::active()->sorting()->get();
        $abouts = About::active()->get();
        $videos = Video::active()->sorting()->get();
        $partners = Partner::active()->sorting()->get();
        $letsgo = Letsgo::active()->first();
        $depoiments = Depoiment::active()->sorting()->get();
        $contact = Contact::first();
        $statute = Statute::active()->first();
        $faqs = Faq::active()->sorting()->get();
        $sessaoFaq = SessaoFaq::active()->first();
        $services = ServiceItem::active()->get();
        $sections = ServiceSection::active()->whereIn('section', [
        'testimonial', 'service', 'gallery', 'planNetwork', 'product',
        'pilar', 'advantages_persona', 'advantages_enterprise', 'partners', 'banner_inner',])->get()->keyBy('section');
        $galleries = ProductGallery::get();
        $serviceLocation = ServiceLocation::active()->first();
        $benefitTopics = BenefitTopic::active()->sorting()->get();
        $planCategories = PlanNetworkCategory::with('plans')->whereHas('plans')->sorting()->active()->get();
        $plans = PlanNetwork::sorting()->active()->get();
        $productCategories = ProductCategory::whereHas('products', function ($query) {
            $query->active()->whereHas('brand', fn ($q) => $q->active());
        })
            ->active()
            ->sorting()
            ->limit(4)
            ->get();
        $products = Product::sorting()->active()->get();
        $reports = Report::active()->get();
        $contractedPlans = Plan::active()->get();
        $popUp = PopUp::active()->first();       

        $directions = Direction::active()->sorting()->get();
        $advantages = Advantage::active()
        ->sorting()
        ->get();
        $benefits = $advantages->groupBy('for_you');
        $benefitForPersonas = $benefits->get('persona', collect());
        $benefitForEnterprises = $benefits->get('enterprise', collect());
        $lineOfTimes = LineOfTime::active()->get();
        $impactSections = ImpactSection::with('metrics')->active()->get();

        $blogSuperHighlights = Blog::whereHas('category', function($active){
            $active->where('active', 1);
        })->superHighlightOnly()->active()->sorting()->limit(6)->get();
        $blogHighlights = Blog::with('category')->active()->highlightOnly()->limit(4)->get();
        // Obter as 5 categorias mais recentes das últimas notícias
        $recentCategories = BlogCategory::where('active', 1)
            ->whereHas('blogs', function ($query) {
                $query->active();
            })
            ->with([
                'subcategories' => function ($query) {
                    $query->where('active', 1)
                        ->orderBy('order')
                        ->orderBy('name');
                },
                'blogs' => function ($query) {
                    $query->active()
                        ->orderBy('created_at', 'DESC');
                }
            ])
            ->withCount([
                'blogs' => function ($query) {
                    $query->active();
                }
            ])
            ->orderBy('created_at', 'DESC')
            ->take(5)
        ->get();
        // Obter as próximas 9 notícias (excluindo o destaque)
        $latestNews = Blog::whereHas('category', function ($query) {
            $query->where('active', 1);
        })
        ->with([
            'category' => function ($query) {
                $query->select('id', 'title', 'slug');
            },
            'subcategory' => function ($query) {
                $query->select('id', 'name', 'slug');
            }
        ])
        ->active()
        ->orderBy('created_at', 'DESC')
        ->limit(12)
        ->get();

        // Pegando os IDs para excluir
        $excludedIds = $recentCategories->pluck('id');

        $blogRelacionados = Blog::whereHas('category')
        ->whereNotIn('blog_category_id', $excludedIds)
        ->active()
        ->sorting()
        ->take(10)
        ->get();

        $blogCategories = BlogCategory::with([
            'subcategories' => function ($query) {
                $query->active()
                    ->with([
                        'blogs' => function ($query) {
                            $query->active()
                                ->sorting()
                                ->limit(4);
                        }
                    ])
                    ->limit(4);
            },
            'blogs' => function ($query) {
                $query->active()
                    ->orderByDesc('date')
                    ->limit(5);
            }
        ])
        ->whereHas('blogs')
        ->active()
        ->sorting()
        ->get();

        // dd($blogCategories);
        $blogNoBairros = Blog::whereHas('category', function($query) {
            $query->where('id', 1)
            ->where('active', 1);
        })
        ->with(['category' => function($query) {
            $query->select('id', 'title', 'slug');
        }])
        ->orderBy('created_at', 'DESC')
        ->active()
        ->limit(10)
        ->get();
        $events = Event::active()
        ->whereMonth('date', now()->month)
        ->orderBy('date', 'asc')
        ->get();
        // $tempo = cache()->remember(
        //     'weather_lauro_de_freitas',
        //     now()->addMinutes(30),
        //     fn () => $weather->current(-12.8944, -38.3272)
        // );
        return compact(
            'events',
            'blogNoBairros',
            'blogCategories',
            'latestNews',
            'blogRelacionados',
            'recentCategories',
            'blogSuperHighlights',
            'announcements',
            'impactSections',
            'lineOfTimes',
            'benefitForPersonas',
            'benefitForEnterprises',
            'directions',
            'templateThemes',
            'advantages',
            'contractedPlans',
            'reports',
            'blogHighlights',
            'productCategories',
            'products',
            'serviceLocation',
            'sessaoFaq',
            'benefitTopics',
            'faqs',
            'depoiments',
            'partners',
            'contact',
            'videos',
            'abouts',         
            'popUp',
            'slides',
            'topics',
            'statute',
            'letsgo',
            'theme',
            'themeData',
            'tenantTheme',
            'services',
            'sections',
            'galleries',
            'planCategories',
            'plans',
        );
    }

    public function filterByCategory($categorySlug = null): array
    {
        $query = Blog::whereHas('category', function ($active) {
            $active->where('active', 1);
        })
            ->with(['category'])
            ->active()
            ->limit(10);

        if ($categorySlug && $categorySlug !== 'todas') {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $allNews = $query->orderBy('created_at', 'DESC')->get();
        $latestNews = $allNews;

        return [
            'allNews' => $allNews,
            'latestNews' => $latestNews,
        ];
    }

    public function filterBySubCategory($categoryId, $subcategoryId = null)
    {   
        $category = BlogCategory::query()
            ->with([
                'blogs' => function ($query) use ($subcategoryId) {
                    $query->with('subcategory')
                        ->when($subcategoryId, function ($query) use ($subcategoryId) {
                            $query->where('blog_subcategory_id', $subcategoryId);
                        })
                        ->orderByDesc('date')
                        ->limit(5);
                }
            ])
            ->findOrFail($categoryId);

        $allNews = Blog::query()
            ->where('blog_category_id', $categoryId)
            ->when($subcategoryId, function ($query) use ($subcategoryId) {
                $query->where('blog_subcategory_id', $subcategoryId);
            })
            ->get();

        return [
            'category' => $category,
            'allNews' => $allNews,
            'latestNews' => $category->blogs,
        ];
    }
}
