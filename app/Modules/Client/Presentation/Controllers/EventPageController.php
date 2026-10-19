<?php

namespace App\Modules\Client\Presentation\Controllers;

use App\Models\Tenant;
use App\Modules\Client\Business\EventPageService;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\View;

class EventPageController
{
    public function __construct(protected EventPageService $service)
    {
    }

    public function index(Request $request, ThemeManager $theme): View
    {
        $tenantTheme = Tenant::current();

        $data = $this->service->getPageData($request, $theme);

        $viewName = $theme->view('event');

        if (ViewFacade::exists($viewName)) {
            return view($viewName, $data)->with('theme', $theme)->with('tenantTheme', $tenantTheme);
        }

        return view($theme->error('404'))->with('theme', $theme)->with('tenantTheme', $tenantTheme);

        // $data = $this->service->getPageData($request);

        // return view('client.blades.event', $data);
    }
}
