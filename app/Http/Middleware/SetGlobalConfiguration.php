<?php

namespace App\Http\Middleware;

use Closure;
use App\Setting;
use Illuminate\Support\Facades\Session;

class SetGlobalConfiguration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
         // Loading the Application Based configurations
        error_log("setting configurations");
        error_log(json_encode($request->path()));
        $mystring = json_encode($request->path());
        Setting::setup_app_config();

        if((strpos($mystring, 'invoice') !== false)&&(strpos($mystring, 'view') !== false)){
            if(Session::get('statusCheck') == 'client') $default_language = "he";
            else $default_language = "en";
        } elseif(strpos($mystring, 'client') !== false) {
            Session::put('statusCheck','client');
            $default_language = "he";
        } elseif(strpos($mystring, 'client') !== true) {
            Session::put('statusCheck','customer');
            $default_language = "en";
        }
        if($default_language)
        {
            app()->setLocale($default_language);
        }
        return $next($request);
    }
}
