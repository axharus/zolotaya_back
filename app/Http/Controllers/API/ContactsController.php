<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 18.05.2017
 * Time: 14:23
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Model\Config;

class ContactsController extends Controller {
    public function index(){
        return response()->json((array) json_decode(Config::val('contacts', false)), 201);
    }
}