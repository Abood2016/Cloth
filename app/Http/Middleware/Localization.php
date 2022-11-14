<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //  $user = $request->user();
        //  $locale = Route::getCurrentRoute()->parameter('locale');
        //   if (!$locale) {
        //        $locale = ($user && $user->locale) ? $user->locale
        //        : config('app.locale');
        //   }

        //   //عشان اعطي قيمة ديفلت لاي راوت بستخدم هاد الميدوير
        //   URL::defaults([
        //       'locale' => $locale,
        //   ]);
         
        //  App::setLocale($locale);

        if(Session::has('locale'))
         app()->setLocale(Session::get('locale'));
         return $next($request);
    }
}
