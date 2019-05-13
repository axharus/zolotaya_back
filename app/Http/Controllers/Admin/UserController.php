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
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function Users() {
        $data = User::all_users();
        return view('admin.user.list', ['data' => $data, 'name' => 'Пльзователи']);
    }

    public function Admin() {
        $data = User::all_admin();
        return view('admin.user.list', ['data' => $data, 'name' => 'Администраторы']);
    }

    public function Edit($id) {
        global $currInput;
        if ($id != 0) {
            $currInput = User::getSingle($id, [])->toArray();
        }

        return view('admin.user.edit', ['inSection' => \H::insection()]);
    }

    public function Save(Request $r) {
        $i = $r->input();
        if (isset($i['success']))
            $i['success'] = 1;
        else
            $i['success'] = 0;
        User::updateRec($i['id'], $i);
        return redirect('/superuser/user/');
    }

    public function Delete($id) {
        User::remove($id);
        return redirect()->back();
    }
}