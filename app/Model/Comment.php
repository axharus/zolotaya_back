<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 18.04.2017
 * Time: 13:10
 */

namespace App\Model;


use Illuminate\Database\Eloquent\ModelNotFoundException;

class Comment extends BaseModel {
    //protected $table = 'stars';
    protected $fillable = 	[	'id', 'user', 'product', 'stars', 'name', 'text'];
    protected $dateFormat = 'U';
    //public $timestamps = false;


    public static function addComment($data, $user){
        if(count($user)){
            $data['user'] = $user['id'];
        }else{
            $data['user'] = \Auth::user()->id;
        }
        self::create(self::fFilter($data));
    }

    public static function getProductComment($id){
        return self::where('product', $id)->where('approved', 1)->with(['user_info'])->get();
    }

    public static function approve($id){
        $comment = self::where('id', $id)->first();
        $comment->approved = 1;
        $comment->save();
    }

    public function user_info(){
        return $this->hasOne('\App\User', 'id', 'user');
    }
}