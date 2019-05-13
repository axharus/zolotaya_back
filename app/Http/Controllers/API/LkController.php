<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 05.05.2017
 * Time: 11:44
 */

namespace App\Http\Controllers\API;


use App\Helper\Uploader;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\User;
use Illuminate\Http\Request;
use Validator;

class LkController extends Controller {
    public function updateDispatch(Request $request){
        User::updateUser(['dispatch' => json_encode($request->except('token'))]);

        return response()->json(true, 201);
    }

    public function getUser(){
        $user = \Auth::user()->toArray();
        $unset = ['created_at', 'login', 'updated_at', 'id'];
        foreach ($unset as $item) {
            unset($user[$item]);
        }
        return response()->json($user, 201);
    }

    public function orders(){
        return response()->json(Order::getLkUserOrders(['created_at', 'order', 'orderid', 'success']), 201);
    }

    public function updateProfile(Request $request){
        $data = $request->input();
        //dd($data);
        $el = array_first($request->file());

        if($data['sex'] === "null"){
            unset($data['sex']);
        }

        if($el){
            if(\Auth::user()->photo){
                Uploader::del(\Auth::user()->photo);
            }
            $file = Uploader::go($el, '109,50', '109,50');
            $data['photo'] = $file;
        }
        User::updateUser($data);

        return response()->json(true, 201);
    }

    public function updateSecurity(Request $request){
        $data = $request->input();
        if(isset($data['Passold']) && $data['Passold']){
            if(!\Hash::check($data['Passold'], User::getPassHash()))
                return response()->json(['Passold' => [trans('m.Не верный пароль')]]);
            $labels = [
                'Passold'=> trans('m.Старый пароль'),
                'Passnew'=> trans('m.Новый пароль'),
                'Passrep'=> trans('m.Повторите пароль')
            ];

            $valid = Validator::make($data, [
                'Passold'   => 'required|min:6|max:25',
                'Passnew'   => 'required|min:6|max:25',
                'Passrep'   => 'required|min:6|max:25|same:Passnew',
            ]);
            $valid->setAttributeNames($labels);

            if($valid->fails()){
                return response()->json($valid->messages(), 201);
            }

            User::setPassHash(\Hash::make($data['Passnew']));
        }

        if(isset($data['Mold']) && $data['Mold']){
            if($data['Mold'] != \Auth::user()->email)
                return response()->json(['Mold' => [trans('m.Не верный E-mail')]]);
            $labels = [
                'Mold'=> trans('m.Старый E-mail'),
                'Mnew'=> trans('m.Новый E-mail'),
            ];

            $valid = Validator::make($data, [
                'Mold'   => 'required|email|',
                'Mnew'   => 'required|email',
            ]);
            $valid->setAttributeNames($labels);

            if($valid->fails()){
                return response()->json($valid->messages(), 201);
            }        }

        return response()->json(false, 201);
    }
}