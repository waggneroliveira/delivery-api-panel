<?php

namespace App\Modules\Client\Presentation\Controllers;

use App\Models\Tenant;
use App\Modules\Client\Business\ContactPageService;
use App\Services\ThemeManager;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\View;

class ContactPageController
{
    public function __construct(protected ContactPageService $service)
    {
    }

    public function index(ThemeManager $theme): View
    {
        $tenantTheme = Tenant::current();

        $data = $this->service->getPageData($theme);

        $viewName = $theme->view('contact');

        if (ViewFacade::exists($viewName)) {
            return view($viewName, $data)->with('theme', $theme)->with('tenantTheme', $tenantTheme);
        }

        return view($theme->error('404'))->with('theme', $theme)->with('tenantTheme', $tenantTheme);

    }
}
