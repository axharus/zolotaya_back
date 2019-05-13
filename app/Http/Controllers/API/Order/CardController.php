<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 08.05.2017
 * Time: 17:18
 */

namespace App\Http\Controllers\API\Order;


use App\Http\Controllers\Controller;
use App\Model\Meta;
use App\Model\Order;
use App\Model\Product;
use App\Model\ProductLike;
use Illuminate\Http\Request;
use Mockery\Exception;
use Validator;

class CardController extends Controller {
    public function getProducts(Request $request) {
        $id = json_decode($request->card);
        $data = Product::getInArray($id, ['id', 'name_ru', 'name_ua', 'price', 'gallery_hover', 'gallery', 'stock']);
        $color = Meta::getType('color', ['id', 'data']);
        $size = Meta::getType('size', ['id', 'name_ru', 'name_ua']);
        return response()->json([$data, $color, $size], 201);
    }

    public function createOrder(Request $request) {
        $valid = Validator::make($request->input(), [
            'order' => 'required',
            'contacts' => 'required',
        ]);
        if ($valid->fails()) {
            return response()->json('Invalid request', 400);
        }

        $data = $request->input();
        if(\Auth::check()){
            $data['user'] = \Auth::user()->id;
        }

        $data['orderid'] = rand(1000000, 10000000);

        $mailer = new MailerOrder($data);
        $mailer->send_admin();
        $mailer->send_user();
        foreach ($data['order'] as $datum) {
            ProductLike::addLike($datum['id'],$data['orderid']);
            Product::orderStock($datum['id'], $datum['count']);
        }
        $data['success'] = 'Зарезервирован';

        Order::addOrder($data);

        return response()->json($data['orderid'], 201);
    }


    public function simple(Request $r){
        try{
            $i = $r->input();

            $data = [
                'mail_content' => '',
                'subject' => 'Быстрый заказ с сайта '.env('FRONT')
            ];

            $data['mail_content'] .= "<tr><td align='right'>Имя</td><td>:</td><td>" . $i['name'] . "</td></tr>";
            $data['mail_content'] .= "<tr><td align='right'>Номер телефона</td><td>:</td><td>" . $i['phone'] . "</td></tr>";
            $data['mail_content'] .= "<tr><td align='right'>Комментарий</td><td>:</td><td>" . $i['text'] . "</td></tr>";
            $data['mail_content'] .= "<tr><td align='right'>Ссылка на товар</td><td>:</td><td>" . (env('FRONT').'/product/'.$i['id']) . "</td></tr>";

            $email = (array) \C::val('admin_mail');

            \Mail::send('email.order', $data, function($m) use ($email){
                $m->from(env('FROM_MAIL'), 'Интернет-магазин');

                $m->to($email, 'Admin')->subject('Запрос заказа');
            });

            return response()->json(true, 201);
        }catch (Exception $e){
            return response()->json(false, 500);
        }
    }

    public function miniBucket(Request $request){
        $out = [];
        $out['product'] = Product::getInArray(json_decode($request->input('id')), ['gallery', 'name_ru', 'name_ua', 'price', 'id']);
        if(json_decode($request->input('meta'))){
            $out['color'] = Meta::getType('color');
            $out['size'] = Meta::getType('size');
        }
        return response()->json($out, 201);
    }
}