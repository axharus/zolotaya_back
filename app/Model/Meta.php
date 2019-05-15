<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 18.04.2017
 * Time: 13:10
 */

namespace App\Model;




class Meta extends BaseModel {
    protected $table = 'meta';
    protected $fillable = 	[	'name_ru', 'name_ua', 'data', 'type', 'sort', 'parent'];
    //protected $dateFormat = 'U';
    public $timestamps = false;
    public $section_id = 0;

    public static function updateRecord($i){
        if(!$i['id']){
            try{
                self::create(self::fFilter($i));
            }catch (\Exception $e){
                dd($e);
                return $e;
            }
        }else{
            self::where('id', $i['id'])->update(self::fFilter($i));
        }
    }

    public static function getWhereIn($array){
        return self::whereIn('id', $array)->select('id', 'name_ru', 'name_ua')->get();
    }

    public static function getType($type, $select = "*", $with = []){
        return self::where('type', $type)->select($select)->with($with)->orderBy('sort')->get();
    }

    public static function getFooter($select = "*"){
        return self::where('type', 'footer')->select($select)->get();
    }


    public static function getCat($select = "*"){
        return self::with('withCatProducts')->select($select)->get();
    }

    public static function getCatFourCount($id){
        $meta = new self();
        $meta->section_id = $id;
        return $meta->withCount('withCatProducts')->where('type', 'cat')->orderBy('sort')->get();
    }

    public static function getOne($id){
        return self::where('id', $id)->firstOrFail();
    }

    public function withCatProducts(){
        return $this->hasMany('\App\Model\Product', 'cat', 'id')->where('section', $this->section_id);
    }
}