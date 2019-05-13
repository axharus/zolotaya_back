<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 12.05.2017
 * Time: 11:26
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\Product;
use Illuminate\Http\Request;

class OrdersController extends Controller {
    private $status = [
        'Зарезервирован'=>'Зарезервирован',
        'Ожитает оплату'=>'Ожитает оплату',
        'Возврат'=>'Возврат',
        'Завершен'=>'Завершен',
    ];

    public function All() {
        $data = Order::iAll();
        return view('admin.orders.list', ['data' => $data]);
    }

    public function Edit($id) {
        global $currInput;

        if ($id != 0) {
            $currInput = Order::getSingle($id, ['profile'])->toArray();
        }

        return view('admin.orders.edit', ['status'=> $this->status]);
    }

    public function Save(Request $r) {
        $i = $r->input();

        if($i['success'] == 'Возврат'){
            $order = Order::getSingle($i['id'], ['profile'])->toArray();
            if($order['success'] != 'Возврат'){
                foreach ($order['order'] as $item) {
                    Product::orderStock($item['id'], -$item['count']);
                }
            }

        }


        Order::updateRec($i['id'], $i);
        return redirect('/superuser/orders/');
    }

    public function Delete($id) {
        Order::remove($id);
        return redirect()->back();
    }
}