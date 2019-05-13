<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jek
 * Date: 01.09.2016
 * Time: 14:37
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class AdminController extends BaseController{
    function __construct(Request $r){
        if(isset($_COOKIE['i18n'])){
            app()->setLocale($_COOKIE['i18n']);
        }else{
            setcookie("i18n", 'ru', time()+(60*60*24*300),"/");
        }
    }
}