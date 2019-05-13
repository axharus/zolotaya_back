<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\Config;
use Illuminate\Http\Request;
use App\Helper\Valid;

class ContactsController extends AdminController{
    public function main(){
        return redirect('/superuser/config');
    }

    public function index(){
        global $currInput;
        $i = Config::val('contacts', false);
        $currInput = (array) json_decode($i);
        return view('admin.contacts');
    }

    public function indexSave(Request $r){
        $i = $r->input();
        unset($i["_token"]);
        \C::setVal(['contacts'=> json_encode($i)]);
        return redirect()->back();
    }
}