<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Jenssegers\Date\Date;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function __construct(Request $r){
        if(!empty(\Request::header('Content-Language'))){
            app()->setLocale(\Request::header('Content-Language'));
        }else{
            app()->setLocale('ru');
        }
        Date::setLocale(app()->getLocale());
    }

    function i18n($lang){
        app()->setLocale($lang);
        setcookie("i18n", strtolower($lang), time()+(60*60*24*300),"/");
        return redirect()->back();
    }



}
