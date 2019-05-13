<?php
namespace App\Model;


use Illuminate\Database\Eloquent\ModelNotFoundException;

class Subscriber extends BaseModel{
    protected $table = 'subscribers';
    protected $fillable = 	[	'name'	,'email'];
    //protected $dateFormat = 'U';
    public $timestamps = false;


    public static function addOne($input){
        try{
            self::create(self::fFilter($input));
            return true;
        }catch (\Exception $e){
            return false;
        }
    }
}