<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jek
 * Date: 18.01.2017
 * Time: 20:16
 */

namespace App\Http\Controllers;


class IndexController extends Controller
{
    public function index(){
        return view('welcome');
    }
}