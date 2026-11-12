<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request and set application locale.
     *
     * @param  Request  $request
     * @param  Closure(Request): (Response)  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = ['en', 'bn'];

        // Check if query parameter sets language
        if ($request->has('lang')) {
            $lang = (string) $request->get('lang');
            if (in_array($lang, $supportedLocales, true)) {
                Session::put('locale', $lang);
            }
        }

        $currentLocale = Session::get('locale', config('app.locale', 'en'));

        if (in_array($currentLocale, $supportedLocales, true)) {
            App::setLocale($currentLocale);
        } else {
            App::setLocale('en');
        }

        return $next($request);
    }
}

