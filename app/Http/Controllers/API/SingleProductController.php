<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Comment;
use App\Model\Meta;
use App\Model\Product;
use App\Model\Stars;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Validator;

class SingleProductController extends Controller {

    public function get($id) {
        $product = Product::getSingle($id, ['sec', 'category', 'stars']);

        $colors = [];
        foreach ($product->color as $name => $item) {
            $colors[] = Meta::getOne($item);
        }
        $product->color = $colors;

        $sizes = [];
        foreach ($product->size as $name => $item) {
            $sizes[] = Meta::getOne($item)->toArray();
        }
        usort($sizes, function($a, $b){
            if ($a == $b) {
                return 0;
            }
            return $a['sort']>$b['sort'] ? 1 : -1;
        });
        $product->size = $sizes;

        if ($product->related) {
            $product->related = $this->getRelated($product->related);
        }

        if ($product->to_buy) {
            $product->to_buy = $this->getRelated($product->to_buy);
        }


        $product->delivery_text_ru = \C::val('delivery_text_ru', false);
        $product->delivery_text_ua = \C::val('delivery_text_ua', false);
        return response()->json($product, 201);
    }

    public function getRelated($data){
        $related = [];
        //dd(count($data), gettype($data));
        if(gettype($data) == 'string') $data = json_decode($data);
        foreach ($data as $id) {
            $data = Product::getSingle($id, ['stars'], ['name_ru', 'name_ua', 'gallery_hover', 'gallery','color','size', 'price', 'bprice', 'id']);
            if($data){
                $count = 0;
                $stars = 0;
                foreach ($data->stars as $star) {
                    $stars += $star->star;
                    $count++;
                }
                unset($data->stars);
                $data->star = $stars > 0 ? round($stars / $count) : 0;

                $related[] = $data;
            }
        }
        return $related;
    }

    public function addComment(Request $request) {
        $rules = [
            'name' => 'required|min:6',
            'text' => 'required|min:6',
            'recapcha' => 'required',
        ];
        if (!\Auth::check()) {
            $rules['email'] = 'required|min:6|email|unique:users';
        }
        $valid = Validator::make($request->input(), $rules);
        $labels = [
            'email' => "E-mail",
            'name' => trans('m.Имя'),
        ];

        $valid->setAttributeNames($labels);
        if ($valid->fails()) {
            return response()->json($valid->messages(), 201);
        }

        $user = [];
        if (!\Auth::check()) {
            $user = $this->registration($request->name, $request->email);
        }

        $client = new Client();
        $result = $client->post('https://www.google.com/recaptcha/api/siteverify', ['form_params' => [
            'secret' => '6Lftxh8UAAAAALijH0cCP5L1dId09ERWobJ_K8j6',
            'response' => $request->recapcha
        ]]);
        $result = json_decode((string)$result->getBody());
        if ($result->success) {
            Comment::addComment($request->input(), $user);
            return response()->json(true, 201);
        }
        return response()->json('reCaptcha error', 400);
    }

    public function getComment($id) {
        return response()->json(Comment::getProductComment($id), 201);
    }

    public function registration($name, $email) {
        $password = str_random(8);
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password
        ];

        $user = User::newUser($data);

        $data = [
            'mail_content' => '',
            'subject' => 'Информация для входа на сайт ' . env('FRONT')
        ];

        $data['mail_content'] .= "<tr>\n<td align='right'>\n Логин \n</td>\n<td>\n:\n</td>\n<td>\n" . $email . "\n</td>\n</tr>";
        $data['mail_content'] .= "<tr>\n<td align='right'>\n Пароль \n</td>\n<td>\n:\n</td>\n<td>\n" . $password . "\n</td>\n</tr>";


        \Mail::send('email.autoUser', $data, function ($m) use ($email) {
            $m->from(env('FROM_MAIL'), 'Интернет-магазин');

            $m->to($email, 'Admin')->subject('Запрос со страницы Оптовых покупателей');
        });
        return $user;
    }

}