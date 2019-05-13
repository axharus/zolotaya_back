<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 18.04.2017
 * Time: 13:10
 */

namespace App\Model;


class Order extends BaseModel {
    protected $fillable = 	['orderid',	'order', 'contacts', 'user', 'success', 'note'];
    protected $dateFormat = 'U';
    protected $casts = [
        'order' => 'array',
        'contacts' => 'array'
    ];

    public static function addOrder($data){
        return self::create(self::fFilter($data));
    }

    public static function getLkUserOrders($select = ['*']){
        return self::where('user', \Auth::user()->id)->select($select)->orderByDesc('created_at')->get();
    }

    public function profile(){
        return $this->hasOne('\App\User', 'id', 'user');
    }
}