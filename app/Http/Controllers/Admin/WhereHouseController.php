<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\Config;
use Illuminate\Http\Request;
use App\Helper\Valid;

class WhereHouseController extends AdminController{
    public function index(){
        global $currInput;
        $i = Config::val('wherehouse', false);
        $currInput = (array) json_decode($i);
        return view('admin.wherehouse');
    }

    public function indexSave(Request $r){
        $i = $r->input();
        unset($i["_token"]);
        \C::setVal(['wherehouse'=> json_encode($i)]);
        return redirect()->back();
    }
}