<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 13.05.2017
 * Time: 15:44
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Model\Product;

class CatalogsController extends Controller {
    public function get($section){
        $select = [
            'id','name_ru','name_ua','price','bprice','gallery_hover', 'gallery','color','size','vendor','created_at'
        ];
        $out = Product::getInSection($section, $select, ['stars'], 0, 12);
        return response()->json($out, 201);
    }

    public function more($section, $offset){
        $select = [
            'id','name_ru','name_ua','price','bprice','gallery_hover', 'gallery','vendor','created_at'
        ];
        $out = Product::getInSection($section, $select, ['stars'], $offset, 12);
        return response()->json($out, 201);
    }
}