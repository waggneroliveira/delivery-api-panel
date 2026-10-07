<?php

namespace App\Modules\Client\Presentation\Controllers;

use App\Models\Tenant;
use App\Modules\Client\Business\BlogPageService;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

class BlogPageController
{
    protected ThemeManager $theme;
    public function __construct(protected BlogPageService $service, ThemeManager $theme)
    {
        $this->theme = $theme;
    }

    public function index(Request $request, $category = null): View
    {
        $tenantTheme = Tenant::current();
        $data = $this->service->getIndexData($request, $category, $this->theme);
        
        $viewName = $this->theme->view('blog');

        if (ViewFacade::exists($viewName)) {
            return view($viewName, $data)->with('theme', $this->theme)->with('tenantTheme', $tenantTheme);
        }

        return view($this->theme->error('404'))->with('theme', $this->theme)->with('tenantTheme', $tenantTheme);

    }

    public function blogInner($slug = null)
    {
        $tenantTheme = Tenant::current();
        $data = $this->service->getInnerData($slug, $this->theme);

          // Se o service já definiu uma view de erro/fallback
        if (isset($data['view'])) {
            return $data['view']->with('theme', $this->theme)->with('tenantTheme', $tenantTheme);
        }

        // Página interna do produto
        $viewName = $this->theme->view('blog-inner');

        if (View::exists($viewName)) {
            return view($viewName, $data)->with('theme', $this->theme)->with('tenantTheme', $tenantTheme);
        }

        // Template não possui página interna de produto
        return view($this->theme->error('404'))->with('theme', $this->theme)->with('tenantTheme', $tenantTheme);


        if (isset($data['view'])) {
            return view($data['view']);
        }

        // view()->share('blogInner', $data['blogInner']);
        // return view($this->theme->view('blog-inner'), $data);
    }
}
