<?php

namespace App\Http\Controllers\API;

use App\Model\Subscriber;
use Illuminate\Http\Request;
use Validator;

class SubscribersController{
    public function add(Request $request){
        $labels = [
            'email'=> "Email"
        ];

        $valid = Validator::make($request->all(), [
            'email'  => 'required|email|unique:subscribers,email',
        ]);

        $valid->setAttributeNames($labels);

        if($valid->fails()){
            return json_encode($valid->messages());
        }

        return json_encode(Subscriber::addOne($request->all()));
    }
}