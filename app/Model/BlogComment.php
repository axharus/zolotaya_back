<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 18.04.2017
 * Time: 13:10
 */

namespace App\Model;


use Illuminate\Database\Eloquent\ModelNotFoundException;

class BlogComment extends BaseModel {
    protected $table = 'blog_comments';
    protected $fillable = 	[	'id', 'user', 'record', 'parent', 'text'];
    protected $dateFormat = 'U';
    //public $timestamps = false;


    public static function addComment($data){
        $data['user'] = \Auth::user()->id;
        self::create(self::fFilter($data));
    }

    public static function getRecordComment($id){
        return self::where('parent', 0)->where('record', $id)->with(['user_info', 'child'])->get();
    }

    public function user_info(){
        return $this->hasOne('\App\User', 'id', 'user')->select(['name', 'second', 'photo', 'id']);
    }

    public function child(){
        return $this->hasMany('\App\Model\BlogComment', 'parent', 'id')->with(['user_info']);
    }

}