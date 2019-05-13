<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jek
 * Date: 04.07.2016
 * Time: 13:52
 */

namespace App\Model;


use Illuminate\Database\Eloquent\ModelNotFoundException;

class BaseModel extends \Eloquent{

    public $choosen = false;

    public static function getR($id){
        try{
            $self = new static();
            if($self->choosen){
                $data = self::where("id", $id)->firstOrFail();
                foreach ($self->choosen as $choosen) {
                    try{
                        $data->{$choosen} = implode(',', $data->{$choosen});
                    }catch (\Exception $e){}

                }
                return $data;
            }
            return self::where("id", $id)->firstOrFail();
        }catch(ModelNotFoundException $e){
            return false;
        }
    }

    public static function getSingle($id, $with, $select = ['*']){
        try{
            return self::where('id', $id)->select($select)->with($with)->firstOrFail();
        }catch (ModelNotFoundException $e){
            return false;
        }
    }

    public static function iAll(){
        return self::all();
    }


    public static function fFilter($i){
        $self = new static();
        $out = [];
        foreach ($self->getFillable() as $item) {
            if(isset($i[$item])){
                if($self->choosen && in_array($item, $self->choosen)){
                    $out[$item] = json_encode(array_filter(explode(',',$i[$item])));
                }else{
                    $out[$item] = $i[$item];
                }

            }
        }
        return $out;
    }

    public static function remove($id){
        self::where('id', $id)->delete();
    }

    public static function updateRec($id, $input){
        if($id){
            return self::where('id', $id)->update(self::fFilter($input));
        }
        unset($input['id']);
        return self::create(self::fFilter($input));

    }
}