<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 18.04.2017
 * Time: 13:10
 */

namespace App\Model;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\Paginator;

class Blog extends BaseModel {
    protected $fillable = 	['type', 'author', 'name_ru', 'name_ua', 'sub_ru', 'sub_ua',
        'page', 'content_ru', 'content_ua', 'img', 'for', 'tags', 'quote_ru', 'quote_ua',
        'quote_img','content2_ru', 'content2_ua',
    ];
    protected $table = 'blog';
    protected $dateFormat = 'U';
    protected $casts = [
        'tags' => 'array'
    ];

    public static function getByType($type){
        return self::where('type', $type)->get();
    }

    public static function getFiltered($type, $filter, $select = ['*']){
        $query = self::where('type', $type);

        Paginator::currentPageResolver(function() use($filter){
            return $filter->page;
        });

        if(isset($filter->for) && $filter->for){
            $query = $query->where('for', $filter->for);
        }

        if(isset($filter->tags) && $filter->tags){
            $query = $query->where('tags', 'LIKE', '%"'.$filter->tags.'"%');
        }

        $query = $query->select($select)->with(['user', 'user_like'])->withCount('likes')->withCount('comments');

        if(isset($filter->sort)){
            $query = self::filterOrder($query, $filter->sort);
        }

        return $query->paginate(5);
    }

    public static function getSingle($id, $with, $select = ['*']){
        try{
            return self::where('id', $id)->select($select)->with($with)->withCount('likes')->withCount('comments')->firstOrFail();
        }catch (ModelNotFoundException $e){
            return false;
        }
    }

    public static function filterOrder($query, $type){
        switch ($type){
            case 1:
                return $query->orderBy('likes_count', 'desc');
            case 2:
                return $query->orderBy('created_at', 'desc');
        }
    }

    public static function getRecords($type, $limit, $select = ['*'], $with = []){
        return self::where('type', $type)->with($with)->limit($limit)->select($select)->orderBy('created_at', 'desc')->get();
    }

    public function user_like(){
        return $this->hasOne('\App\Model\BlogLike', 'record', 'id');
    }

    public function comments(){
        return $this->hasOne('\App\Model\BlogComment', 'record', 'id');
    }

    public function likes(){
        return $this->hasOne('\App\Model\BlogLike', 'record', 'id');//->selectRaw('record, count(*) as count')->groupBy('record');
    }

    public function user(){
        return $this->hasOne('\App\User', 'id', 'author')->select(['photo', 'id', 'name', 'second']);
    }
}