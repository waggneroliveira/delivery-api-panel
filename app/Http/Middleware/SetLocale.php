<?php
namespace App\Http\Middleware;

use Log;
use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        if (session()->has('locale')) {
            $locale = session('locale');
            \Log::info("Setting locale to: $locale");
            App::setLocale($locale);
        } else {
            \Log::info("No locale set in session.");
        }
        return $next($request);
    }

}
