<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 22.05.2017
 * Time: 14:58
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Model\SEO;
use Illuminate\Http\Request;

class SEOController extends Controller {
    public function full(Request $request){
        $url = $request->input()['url'];
        return response()->json(SEO::getByUrl($url, ['name_ru', 'name_ua', 'sub_ru', 'sub_ua', 'content_ru', 'content_ua']), 201);
    }

    public function tags(Request $request){
        $url = $request->input()['url'];
        return response()->json(SEO::getByUrl($url, ['title_ru', 'title_ua', 'keywords_ru', 'keywords_ua', 'description_ru', 'description_ua']), 201);
    }
}