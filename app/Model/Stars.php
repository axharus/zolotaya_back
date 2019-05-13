<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 18.04.2017
 * Time: 13:10
 */

namespace App\Model;


use Illuminate\Database\Eloquent\ModelNotFoundException;

class Stars extends BaseModel {
    protected $table = 'stars';
    protected $fillable = 	[	'id', 'user', 'star', 'product'];
    //protected $dateFormat = 'U';
    public $timestamps = false;


    public static function addStar($stars, $product){
        try{
            $data = self::where('user', \Auth::user()->id)->where('product', $product)->firstOrFail();
            $data->star = $stars;
            $data->save();
            return $data;
        }catch (ModelNotFoundException $e){
            return self::create([
                'user'=>\Auth::user()->id,
                'star'=>$stars,
                'product'=>$product
            ]);
        }
    }
}