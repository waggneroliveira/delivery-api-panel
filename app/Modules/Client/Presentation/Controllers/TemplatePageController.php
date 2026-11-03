<?php

namespace App\Modules\Client\Presentation\Controllers;

use App\Modules\Client\Business\TemplatePageService;
use App\Services\ThemeManager;
use Illuminate\Http\Request;

class TemplatePageController
{
    protected ThemeManager $theme;

    public function __construct(protected TemplatePageService $service, ThemeManager $theme)
    {
        $this->theme = $theme;
    }

    public function templateAll(Request $request)
    {
        $data = $this->service->getTemplateListData($request, $this->theme);

        return view($this->theme->view('templates'), $data);
    }

    public function templateInner($slug = null, $templateVariation = null){
        $data = $this->service->getInnerData($slug, $templateVariation, $this->theme);
  
        if (isset($data['view'])) {
            return view($data['view']);
        }

        view()->share('templateThemeInner', $data['templateThemeInner']);

        return view($this->theme->view('template'), $data);
    }
}
