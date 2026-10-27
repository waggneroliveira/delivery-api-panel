<?php

namespace App\Modules\Client\Presentation\Controllers;

use App\Models\Contact;
use App\Models\PlanNetwork;
use App\Modules\Client\Business\HomePageService;
use App\Services\FootballDataService;
use App\Services\ThemeManager;
use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomePageController
{
    public function __construct(protected HomePageService $service)
    {
    }

    public function index(ThemeManager $theme, WeatherService $weather, FootballDataService $footballDataService): View
    {
        $data = $this->service->getIndexData($theme, $weather, $footballDataService);

        return view($theme->view('index'), $data);
    }

    public function filterByCategory($categorySlug = null): JsonResponse
    {
        $data = $this->service->filterByCategory($categorySlug);
        $html = view('client.themes.blog.tp-01.ajax.filter-blog-homePage', [
            'latestNews' => $data['latestNews'],
        ])->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $data['allNews']->count(),
            'latest_count' => $data['latestNews']->count(),
        ]);
    }
    public function filterBySubCategory(Request $request): JsonResponse
    {

        $data = $this->service->filterBySubCategory(
            $request->category_id,
            $request->subcategory_id
        );

        $html = view('client.themes.blog.tp-01.ajax.filter-blog-homePage', [
            'category' => $data['category'],
        ])->render();
        
        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $data['allNews']->count(),
            'latest_count' => $data['latestNews']->count(),
        ]);
    }

    public function getPlansByCategory($id)
    {
        $contact = Contact::first();
        $plans = PlanNetwork::select(
        'plan_networks.plan_network_category',
        'plan_networks.title',
        'plan_networks.subtitle',
        'plan_networks.bandwidth_limit',
        'plan_networks.bandwidth_unit',
        'plan_networks.description',
        'plan_networks.price',
        'plan_networks.active',
        'plan_networks.sorting'
        )->where('plan_network_category', $id)
        ->active()->sorting()->get();

        $html = view('client.themes.provedor.tp-01.blades.ajax.plan', compact('plans', 'contact'))->render();

        return response()->json(['html' => $html]);
    }

    public function policePrivacy(ThemeManager $theme): View
    {
        $data = $this->service->getIndexData($theme);

        return view($theme->view('privacy-of-police'), $data);
    }
    public function useTerm(ThemeManager $theme): View
    {
        $data = $this->service->getIndexData($theme);

        return view($theme->view('use-of-term'), $data);
    }
}
