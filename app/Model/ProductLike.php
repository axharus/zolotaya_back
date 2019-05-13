<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 18.04.2017
 * Time: 13:10
 */

namespace App\Model;


use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductLike extends BaseModel {
    protected $table = 'product_like';
    protected $fillable = 	[	'id', 'product', 'orderid', 'user'];
    //protected $dateFormat = 'U';
    public $timestamps = false;


    public static function addLike($product, $orderid){
        $data = [
            'product'   => $product,
            'orderid'   => $orderid
        ];

        if(\Auth::check()){
            $data['user'] = \Auth::user()->id;
        }

        self::create(self::fFilter($data));
    }
}