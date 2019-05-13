<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 22.05.2017
 * Time: 14:29
 */

namespace App\Model;


class SEO extends BaseModel {
    protected $table = 'seo';
    public $timestamps = false;
    protected $fillable = 	['url', 'keywords_ru', 'keywords_ua', 'description_ru', 'description_ua','title_ru', 'title_ua', 'name_ru', 'name_ua', 'sub_ru', 'sub_ua', 'content_ru', 'content_ua'];

    public static function getByUrl($url, $select = ['*'], $with = []){
        return self::where('url', $url)->select($select)->with($with)->first();
    }
}