<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 18.04.2017
 * Time: 13:10
 */

namespace App\Model;


use Illuminate\Database\Eloquent\ModelNotFoundException;

class Page extends BaseModel {
    protected $table = 'pages';
    protected $fillable = 	[	'id', 'name_ru', 'name_ua', 'photo', 'text_ru', 'text_ua'];
    protected $dateFormat = 'U';
    //public $timestamps = false;


}