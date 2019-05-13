<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 12.05.2017
 * Time: 11:26
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\Page;
use Illuminate\Http\Request;

class PagesController extends Controller {
    public function All() {
        $data = Page::iAll();
        return view('admin.pages.list', ['data' => $data]);
    }

    public function Edit($id) {
        global $currInput;
        if ($id != 0) {
            $currInput = Page::getSingle($id, [])->toArray();
        }
        return view('admin.pages.edit');
    }

    public function Save(Request $r) {
        $i = $r->input();
        Page::updateRec($i['id'], $i);
        return redirect('/superuser/pages/');
    }

    public function Delete($id) {
        Page::remove($id);
        return redirect()->back();
    }
}