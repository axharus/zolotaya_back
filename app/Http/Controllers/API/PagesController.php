<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Comment;
use App\Model\Meta;
use App\Model\Page;
use App\Model\Product;
use App\Model\Stars;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Validator;

class PagesController extends Controller {
    public function get($id){
        return response()->json(Page::getSingle($id, []));
    }
}