<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\Config;
use Illuminate\Http\Request;
use App\Helper\Valid;

class IndexController extends AdminController{
    public function main(){
        return redirect('/superuser/config');
    }

    public function index(){
        global $currInput;
        $i = Config::val('index', false);
        $currInput = (array) json_decode($i);
        return view('admin.index');
    }

    public function indexSave(Request $r){
        $i = $r->input();
        unset($i["_token"]);
        \C::setVal(['index'=> json_encode($i)]);
        return redirect()->back();
    }

    public function config(){
        global $currInput;
        $i = Config::get()->toArray();
        foreach ($i as $item) {
            $currInput[$item['name']] = $item['value'];
        }
        return view('admin.config');
    }

    public function configSave(Request $r){
        $i = $r->input();
        if(!isset($i['main_news'])) $i['main_news'] = '';
        if(!isset($i['main_articles'])) $i['main_articles'] = '';
        if(!isset($i['main_reviews'])) $i['main_reviews'] = '';
        unset($i["_token"]);
        \C::setVal($i);
        return redirect()->back();
    }

    public function lang($lg){
        setcookie("i18n", $lg, time()+(60*60*24*300),"/");
        return \Redirect::to('/superuser/');
    }
}