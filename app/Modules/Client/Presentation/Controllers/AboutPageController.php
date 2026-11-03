<?php

namespace App\Modules\Client\Presentation\Controllers;

use App\Models\Tenant;
use App\Modules\Client\Business\AboutPageService;
use App\Services\ThemeManager;
use Illuminate\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

class AboutPageController
{
    public function __construct(protected AboutPageService $service)
    {
    }

    public function index(ThemeManager $theme): View
    {
        $tenantTheme = Tenant::current();

        $data = $this->service->getPageData($theme);

        $viewName = $theme->view('about');

        if (ViewFacade::exists($viewName)) {
            return view($viewName, $data)->with('theme', $theme)->with('tenantTheme', $tenantTheme);
        }

        return view($theme->error('404'))->with('theme', $theme)->with('tenantTheme', $tenantTheme);
    }
}
