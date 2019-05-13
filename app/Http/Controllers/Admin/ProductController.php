<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 18.04.2017
 * Time: 13:04
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AdminController;
use App\Model\Product;
use Illuminate\Http\Request;

class ProductController extends AdminController {
    public function All() {
        $data = Product::iAll();
        return view('admin.product.list', ['data' => $data]);
    }

    public function Edit($id) {
        global $currInput;
        if ($id != 0) {
            $currInput = Product::getR($id)->toArray();
        }

        return view('admin.product.edit', ['inSection' => \H::insection()]);
    }

    public function Save(Request $r) {
        $i = $r->input();
        Product::updateRecord($i['id'], $i);
        return redirect('/superuser/product/');
    }

    public function hotPrice($id, Request $r){
        //dd($id);
        Product::updateRecord($id, ['price'=>$r->price]);
        return response()->json(true, 201);
    }

    public function Delete($id) {
        Product::remove($id);
        return redirect()->back();
    }


}