<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jek
 * Date: 21.07.2016
 * Time: 15:42
 */

namespace App\Helper;


use App\Model\BaseModel;
use Carbon\Carbon;
use Jenssegers\Date\Date;

class Helper
{
    public static function rep($v, $sort = "num")
    {
        if(gettype($v)=="integer") return $v;
        $v = json_decode($v);
        if (gettype($v) == "object")
            $v = get_object_vars($v);
        if (count($v) > 0 && gettype(array_first($v)) == "object") {
            foreach ($v as $key => $val) {
                $v[$key] = get_object_vars($v[$key]);
            }
            if (isset(array_first($v)[$sort])) {
                usort($v, function ($a, $b) use ($sort) {
                    return $a[$sort] - $b[$sort];
                });
            }
        }
        return $v;
    }

    public static function reps($v){
        //$v = json_decode($v);
        return $v;
    }

    public static function isJsonFalse($val){
        debug($val);
        if($val == "[false]" || $val == 'null') return "";
        $json = json_decode($val);
        $rep = [];
        if($json && count($json) > 1){
            foreach ($json as $item) {
                if($item) $rep[] = $item;
            }
            return json_encode($rep);
        }
        return $val;
    }

    public static function admin(){
        return [11, 16];
    }

    public static function isAdmin(){
        return \Auth::check() ? in_array(\Auth::user()->id, self::admin()) : false;
    }

    public static function setReqire($request, $array){
        $params = $request->input();
        $rules = [];
        foreach ($array as $item => $val) {
            $rules[$item] = [
                'required'
            ];
        }

        if (!empty($rules)) {
            $validator = \Validator::make($params,$rules);
            $validator->setAttributeNames($array);
            if ($validator->fails()) {
                return $validator->messages();
            }else{
                return false;
            }
        }
    }

    public static function clearLang($obj){
        $result = [];
        $lang = app()->getLocale();
        if(gettype($obj) != 'object' && gettype($obj) != 'array'){
            $json = json_decode($obj);
            if($json && gettype($obj) != "integer"){
                return self::clearLang($json);
            }
            return $obj;
        }
        foreach ($obj as $key => $item) {
            $explodet = explode("_",$key);
            if(isset($explodet[1]) && $explodet[1] == $lang){
                $result[$explodet[0]] = self::clearLang($item);
            }elseif(!isset($explodet[1])){
                $result[$key] = self::clearLang($item);
            }
        }
        return $result;
    }

    public static function lang($var){
        return $var.'_'.app()->getLocale();
    }

    public static function insection() {
        $insection[] = (object) ['id' => 1, 'name_ru' => 'Новинки', 'name_ua' => 'Новинки'];
        $insection[] = (object) ['id' => 2, 'name_ru' => 'Популярные', 'name_ua' => 'Популярні'];
        $insection[] = (object) ['id' => 3, 'name_ru' => 'Лучшие акции', 'name_ua' => 'Найкращі акції'];
        $insection[] = (object) ['id' => 4, 'name_ru' => 'Распродажа', 'name_ua' => 'Розпродаж'];
        return collect($insection);
    }

    public static function revert_price($value){
        return round($value/floatval(\C::val('usd', false)), 0);
    }


}