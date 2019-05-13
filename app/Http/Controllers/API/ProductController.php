<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 20.02.2017
 * Time: 12:56
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Meta;
use App\Model\Product;
use App\Model\Stars;
use Illuminate\Http\Request;

class ProductController extends Controller{
    public function catalog(){
        $out['sections'] = $this->getMenu();
        $out['size'] = Meta::getType('size', ['name_ua', 'name_ru', 'id'])->toArray();
        $out['color'] = Meta::getType('color', ['data', 'id'])->toArray();
        $out['price'] = Product::prices();
        return response()->json($out, 201);
    }

    public function products(Request $request){
        $filter = $this->decodeFilter((array) json_decode($request->filter));
        $select = [
            'id','name_ru','name_ua','price','bprice','gallery_hover', 'gallery','color','size','vendor','created_at','color','size'
        ];
        $data = Product::catalogSearch($filter, $select);
        $data->each(function ($item){
            $count = 0;
            $stars = 0;
            foreach ($item->stars as $star) {
                $stars += $star->star;
                $count++;
            }
            unset($item->stars);
            $item->star = $stars > 0 ? round($stars/$count) : 0;
        });
        $data = $data->toArray();
        $data['timestamp'] = time();
        return response()->json($data, 201);
    }

    public function decodeFilter($data){
        $out = [];
        foreach ($data as $key => $item) {
            $explode = explode(',', $key);
            if(count($explode) > 1){
                if($item){
                    $out['catalog'][] = $explode;
                }
                continue;
            }else{
                $out[$key] = $item;
            }
        }
        return $out;
    }

    public function stars(Request $request){
        if($request->stars){
            return response()->json(Stars::addStar($request->stars, $request->product), 201);
        }
        return response()->json('Error', 404);
    }

    private function getMenu(){
        $sections = Meta::getType('section', ['name_ru', 'name_ua', 'id']);
        $sections->each(function ($val) {
            $val->category = Meta::getCatFourCount($val->id)->filter(function ($valCat){
                return $valCat->with_cat_products_count != 0;
            });
            $val->category = $val->category->values()->toArray();
        });
        return $sections->toArray();
    }


}