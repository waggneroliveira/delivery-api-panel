<?php

namespace App\Modules\Client\Presentation\Controllers;

use Illuminate\View\View;

class DocumentationController
{
    public function index(): View
    {
        return view('client.documentation.client-module');
    }
}
