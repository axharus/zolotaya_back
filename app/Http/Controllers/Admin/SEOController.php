<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 22.05.2017
 * Time: 14:29
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Model\SEO;
use Illuminate\Http\Request;

class SEOController extends Controller {
    public function All() {
        $data = SEO::iAll();
        return view('admin.seo.list', ['data' => $data]);
    }

    public function Edit($id) {
        global $currInput;
        if ($id != 0) {
            $currInput = SEO::getSingle($id, [])->toArray();
        }

        return view('admin.seo.edit');
    }

    public function Save(Request $r) {
        $i = $r->input();
        SEO::updateRec($i['id'], $i);
        return redirect('/superuser/seo/');
    }

    public function Delete($id) {
        SEO::remove($id);
        return redirect()->back();
    }
}