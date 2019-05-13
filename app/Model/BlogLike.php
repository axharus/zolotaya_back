<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 18.04.2017
 * Time: 13:10
 */

namespace App\Model;


use Illuminate\Database\Eloquent\ModelNotFoundException;

class BlogLike extends BaseModel {
    protected $table = 'blog_likes';
    protected $fillable = 	[	'id', 'user', 'record'];
    //protected $dateFormat = 'U';
    public $timestamps = false;


    public static function addLike($id){
        try{
            self::where('user', \Auth::user()->id)->where('record', $id)->firstOrFail();
            return false;
        }catch (ModelNotFoundException $e){
            self::create([
                'user' => \Auth::user()->id,
                'record'=> $id
            ]);
            return true;
        }
    }

    public static function removeLike($id){

        self::where('user', \Auth::user()->id)->where('record', $id)->delete();
        return true;
    }
}