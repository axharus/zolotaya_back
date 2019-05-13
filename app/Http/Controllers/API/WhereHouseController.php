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
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Validator;

class WhereHouseController extends Controller {
    public function index(){
        return response()->json((array) json_decode(Config::val('wherehouse', false)), 201);
    }

    public function mail(Request $request){
        $i = $request->input();


        if ($this->validator($i)) {
            dd($i);
            return response()->json('Invalid request', 400);
        }
        if (!$this->reCaptcha($i)) {
            return response()->json('reCaptcha error', 400);
        }


        $filter = ['name' => 'Имя', 'second'=>'Фамилия', 'phone'=>'Номер телефона', 'email'=>'Почта', 'text'=>'Сообщение'];
        $data = [
            'mail_content' => '',
            'subject' => 'Запрос со страницы Оптовых покупателей '
        ];
        foreach ($filter as $name => $value) {
            $data['mail_content'] .= "<tr>\n<td align='right'>\n" . $value . "\n</td>\n<td>\n:\n</td>\n<td>\n" . $i[$name] . "\n</td>\n</tr>";
        }

        $email = (array) json_decode(Config::val('wherehouse', false))->email;

        \Mail::send('email.warehouse', $data, function($m) use ($email){
            $m->from(env('FROM_MAIL'), 'Интернет-магазин');

            $m->to($email, 'Admin')->subject('Запрос со страницы Оптовых покупателей');
        });

        return response()->json(true, 201);
    }

    public function validator($i){
        $valid = Validator::make($i, [
            'name'=>'required',
            'phone'=>'required',
            'email'=>'required'
        ]);
        return $valid->fails();
    }

    public function reCaptcha($i){
        $client = new Client();
        $result = $client->post('https://www.google.com/recaptcha/api/siteverify', ['form_params' => [
            'secret' => '6Lftxh8UAAAAALijH0cCP5L1dId09ERWobJ_K8j6',
            'response' => $i['recapcha']
        ]]);
        $result = json_decode((string)$result->getBody());
        return $result->success;
    }
}