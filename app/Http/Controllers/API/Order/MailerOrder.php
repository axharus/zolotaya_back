<?php
/**
 * Created by PhpStorm.
 * User: AxHarus
 * Date: 6/23/2017
 * Time: 13:05
 */

namespace App\Http\Controllers\API\Order;


use App\Model\Meta;
use App\Model\Product;

class MailerOrder {
    private $order;
    private $colors;
    private $sizes;

    function __construct($order) {
        $this->order = $order;
        $this->colors = Meta::getType('color')->toArray();
        $this->sizes = Meta::getType('size')->toArray();
    }

    private function order_information($data) {
        $data['mail_content'] .= "<tr><td align='right'>".trans('Имя')."</td><td>:</td><td>" . $this->order['contacts']['name'] . "</td></tr>";
        $data['mail_content'] .= "<tr><td align='right'>".trans('Номер телефона')."</td><td>:</td><td>" . $this->order['contacts']['phone'] . "</td></tr>";
        $data['mail_content'] .= "<tr><td align='right'>".trans('E-mail')."</td><td>:</td><td>" . $this->order['contacts']['email'] . "</td></tr>";

        if ($this->order['contacts']['city'])
            $data['mail_content'] .= "<tr><td align='right'>".trans('Город для доставки')."</td><td>:</td><td>" . $this->order['contacts']['city'] . "</td></tr>";
        if ($this->order['contacts']['office'])
            $data['mail_content'] .= "<tr><td align='right'>".trans('Отделение новой почты')."</td><td>:</td><td>" . $this->order['contacts']['office'] . "</td></tr>";

        $data['mail_content'] .= "<tr><td align='right'>".trans('Заказ')."</td><td>:</td><td></td></tr>";

        $sum = 0;
        foreach ($this->order['order'] as $product) {
            $sum += intval($product['count']) * intval($product['price']);
            $entity = Product::getSingle($product['id'], []);
            $data['mail_content'] .= "<tr><td align='right'>".trans('Продукт')."</td><td>:</td><td>" . $entity[\H::lang('name')] . "</td></tr>";
            $data['mail_content'] .= "<tr><td align='right'>".trans('Ссылка')."</td><td>:</td><td>" . (env('FRONT').'/product/'.$product['id']) . "</td></tr>";

            $data['mail_content'] .= "<tr><td align='right'>".trans('Цвет')."</td><td>:</td><td>" . $this->search($this->colors, 'id', $product['meta']['color'])[0][\H::lang('name')] . "</td></tr>";
            $data['mail_content'] .= "<tr><td align='right'>".trans('Размер')."</td><td>:</td><td>" . $this->search($this->sizes, 'id', $product['meta']['size'])[0][\H::lang('name')] . "</td></tr>";
            $data['mail_content'] .= "<tr><td align='right'>".trans('Количество')."</td><td>:</td><td>" . $product['count'] . "</td></tr>";
            $data['mail_content'] .= "<tr><td align='right'>".trans('Цена')."</td><td>:</td><td>" . $product['price'] . "</td></tr>";
            $data['mail_content'] .= "<tr><td align='right'>------</td><td>:</td><td>------</td></tr>";
        }
        $data['mail_content'] .= "<tr><td align='right'>".trans('Итого')."</td><td>:</td><td>".$sum."</td></tr>";
        return $data;
    }

    public function send_admin() {
        try {
            $data = [
                'mail_content' => '',
                'subject' => 'Заказ ' . env('FRONT')
            ];

            $data = $this->order_information($data);

            $email = (array)\C::val('admin_mail');

            \Mail::send('email.order', $data, function ($m) use ($email) {
                $m->from(env('FROM_MAIL'), 'Интернет-магазин');

                $m->to($email, 'Admin')->subject('Заказ');
            });

            return response()->json(true, 201);
        } catch (\Exception $e) {
            return response()->json(false, 500);
        }
    }

    public function send_user() {
        try {
            $data = [
                'mail_content' => '',
                'subject' => 'Заказ ' . env('FRONT')
            ];

            $data = $this->order_information($data);

            $email = $this->order['contacts']['email'];

            \Mail::send('email.order', $data, function ($m) use ($email) {
                $m->from(env('FROM_MAIL'), 'Интернет-магазин');

                $m->to($email, $this->order['contacts']['name'])->subject('Заказ');
            });

            return response()->json(true, 201);
        } catch (\Exception $e) {
            return response()->json(false, 500);
        }
    }


    public function search($array, $key, $value) {
        $results = array();

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, $this->search($subarray, $key, $value));
            }
        }

        return $results;
    }
}