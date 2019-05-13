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
use App\User;

class IndexController extends Controller {
    public function index() {
        $out = [];
        $out['index'] = json_decode(\C::val('index', false));
        $in = explode(",", $out['index']->popularIndex);
        $select = [
            'id', 'name_ru', 'name_ua', 'price', 'bprice','gallery_hover', 'gallery','color','size', 'vendor', 'created_at'
        ];
        $out['popular'] = Product::getInArray($in, $select, ['stars'], 0, 12);
        $out['main_news'] = \C::val('main_news', false);
        $out['main_articles'] = \C::val('main_articles', false);
        $out['main_reviews'] = \C::val('main_reviews', false);
        return response()->json($out, 201);
    }

    public function indexGetMore($offset) {
        $in = explode(",", json_decode(\C::val('index', false))->popularIndex);
        $select = [
            'id', 'name_ru', 'name_ua', 'price', 'bprice', 'gallery_hover', 'gallery','color','size', 'vendor', 'created_at'
        ];
        return response()->json(Product::getInArray($in, $select, ['stars'], $offset, 12), 201);
    }

    public function head() {
        $data = [
            'Vkontakte' => \C::val('Vkontakte'),
            'Facebook' => \C::val('Facebook'),
            'Instagram' => \C::val('Instagram'),
            'Twitter' => \C::val('Twitter'),
        ];
        $logo = \U::path(\C::val('logo', false));

        $out['soc'] = $data;
        $out['logo'] = $logo;
        $out['menu'] = $this->getMenu();
        $out['price'] = $this->getPrices();
        $out['cats'] = Meta::getType('cat', ['id', 'name_ru', 'name_ua']);
        $out['usd'] = floatval(\C::val('usd', false));
        $out['phone'] = \C::val('phone', false);
        
        $out['meta'] = [
            'color'=> Meta::getType('color'),
            'size'=>Meta::getType('size')
        ];

        $out['secondMenu'] = Meta::getType('menu', ['name_ru', 'name_ua', 'data']);

        if (\Auth::check()) {
            $out['user'] = [
                'name' => \Auth::user()->name,
                'photo' => \Auth::user()->photo,
            ];
        }


        return response()->json($out, 201);
    }

    public function footer(){
        $out['soc'] = [
            'Vkontakte' => \C::val('Vkontakte'),
            'Facebook' => \C::val('Facebook'),
            'Instagram' => \C::val('Instagram'),
            'Twitter' => \C::val('Twitter'),
        ];
        $out['footer'] = Meta::getFooter();
        $out['conf'] = \C::val('conf');

        return response()->json($out, 201);
    }


    private function getPrices() {
        $price[] = [\C::val('price_d1', false)];
        $price[] = [\C::val('price_d2_1', false), \C::val('price_d2_2', false)];
        $price[] = [\C::val('price_d3_1', false), \C::val('price_d3_2', false)];
        $price[] = [\C::val('price_d4_1', false), \C::val('price_d4_2', false)];
        $price[] = [\C::val('price_d5_1', false), \C::val('price_d5_2', false)];
        $price[] = [\C::val('price_d6', false)];
        return $price;
    }

    private function getMenu() {
        $pubSections = explode(',', \C::val('publicSections', false));
        $sections = Meta::getType('section')->filter(function ($val, $key) use ($pubSections) {
            return in_array($val->id, $pubSections);
        });
        $sections->each(function ($val) {
            $val->category = Meta::getCatFourCount($val->id)->filter(function ($valCat){
                return $valCat->with_cat_products_count != 0;
            });
            $val->category = $val->category->values()->toArray();
        });
        return $sections->toArray();
    }
}