<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 22.05.2017
 * Time: 12:17
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Model\Blog;

class BlogMiniController extends Controller {
    public function full(){
        $out['news'] = Blog::getRecords('news', 3, ['img', 'name_ru', 'name_ua', 'sub_ua', 'sub_ru', 'page', 'id']);
        $out['articles'] = Blog::getRecords('articles', 3, ['img', 'name_ru', 'name_ua', 'sub_ua', 'sub_ru', 'page', 'id']);
        $out['reviews'] = Blog::getRecords('reviews', 3, ['img', 'name_ru', 'name_ua', 'sub_ua', 'sub_ru', 'page', 'id']);
        return response()->json($out, 201);
    }

    public function short(){
        $out['news'] = Blog::getRecords('news', 1, ['img', 'name_ru', 'name_ua', 'sub_ua', 'sub_ru', 'page', 'id'])->toArray()[0];
        $out['articles'] = Blog::getRecords('articles', 1, ['img', 'name_ru', 'name_ua', 'sub_ua', 'sub_ru', 'page', 'id'])->toArray()[0];
        $out['reviews'] = Blog::getRecords('reviews', 1, ['img', 'name_ru', 'name_ua', 'sub_ua', 'sub_ru', 'page', 'id'])->toArray()[0];
        return response()->json($out, 201);
    }
}