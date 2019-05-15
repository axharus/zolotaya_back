<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 16.05.2017
 * Time: 16:09
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Model\Blog;
use App\Model\BlogComment;
use App\Model\BlogLike;
use App\Model\Meta;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Validator;

class BlogController extends Controller {
    public function tags(){
        return response()->json(Meta::getType('tags'), 201);
    }

    public function arts(Request $request){
        $i = json_decode($request->input('filter'));
        $data = Blog::getFiltered($i);
        $data->each(function ($item){
            $item['tags_data'] = Meta::getWhereIn($item['tags']);
        });
        return response()->json($data, 201);
    }

    public function single($id){
        $data = Blog::getSingle($id, ['user', 'user_like']);
        $data['tags_data'] = Meta::getWhereIn($data['tags']);
        return response()->json($data, 201);
    }

    public function addComment($id, Request $request){
        $data = $request->input();
        $data['record'] = $id;
        $valid = Validator::make($data, [
            'text' => 'required',
            'record'    => 'required'
        ]);
        if ($valid->fails()) {
            dd($data);
            return response()->json('Invalid request', 400);
        }

        $client = new Client();
        $result = $client->post('https://www.google.com/recaptcha/api/siteverify', ['form_params' => [
            'secret' => '6Lftxh8UAAAAALijH0cCP5L1dId09ERWobJ_K8j6',
            'response' => $request->recapcha
        ]]);
        $result = json_decode((string)$result->getBody());

        if ($result->success) {
            BlogComment::addComment($data);
            return response()->json(true, 201);
        }
        return response()->json('reCaptcha error', 400);
    }

    public function getComment($id){
        return response()->json(BlogComment::getRecordComment($id), 201);
    }

    public function addLike($id){
        BlogLike::addLike($id);
        return response()->json(true, 201);
    }

    public function removeLike($id){
        BlogLike::removeLike($id);
        return response()->json(true, 201);
    }
}