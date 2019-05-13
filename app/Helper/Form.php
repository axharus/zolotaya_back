<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jek
 * Date: 04.07.2016
 * Time: 15:34
 */

namespace App\Helper;


use App\Model\i18n;
use Illuminate\Http\Request;

class Form extends FormInputs{


    public static function repeaterOpen($name, $desc, $class = ""){
        global $currInput;
        global $thisIsRepeater;
        $thisIsRepeater = 1;

        return view('admin.form.repeaterStart', [
            "name"  => $name,
            "desc"  => $desc,
            'input' => $currInput,
            "class" => $class
        ]);
    }

    public static function repeaterClose($name, $priority = true){
        global $currInput;
        global $thisIsRepeater;
        $thisIsRepeater = 0;
        return view('admin.form.repeaterEnd', [
            'input' => $currInput,
            'name'  => $name,
            'priority' => $priority,
        ]);
    }



    public static function o($action){
        return view('admin.form.startForm', [
            "action"  => $action,
        ]);
    }

    public static function c(){
        return view('admin.form.closeForm');
    }

    public static function langs(){
        return ['Руский' => "_ru", 'Украинский' => "_ua"];
    }



}