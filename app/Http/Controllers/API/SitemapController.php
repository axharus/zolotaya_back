<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Model\Meta;

class SitemapController extends Controller {
    public function index(){
        $out['menu'] = Meta::getType('section', ['name_ru', 'name_ua', 'id'])->each(function ($val) {
            $val->category = Meta::getCatFourCount($val->id)->filter(function ($valCat){
                return $valCat->with_cat_products_count != 0;
            });
            $val->category = $val->category->values()->toArray();
        });
        $out['footer'] = Meta::getFooter();

        return response()->json($out, 201);
    }
}