<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jek
 * Date: 21.07.2016
 * Time: 16:14
 */

namespace App\Helper;


class FormInputs extends FormHelpers{
    public static function input($name, $desc, $require = true, $type = "text", $disable = false, $lang = true){
        global $currInput;
        global $thisIsRepeater;
        return view('admin.form.input.inp', [
            "name"  => $name,
            "desc"  => $desc,
            "placeholder"   => $desc,
            'input' => $thisIsRepeater ? null : $currInput,
            'type'  => $type,
            'disable'   => $disable,
            'require'   => $require,
            'repeater' => $thisIsRepeater,
            'lang'  => $lang
        ]);
    }

    public static function select($name, $desc, $require = true, $data = [], $lang = true, $disable = false){
        global $currInput;
        global $thisIsRepeater;
        return view('admin.form.input.select', [
            "name"  => $name,
            "desc"  => $desc,
            "placeholder"   => $desc,
            'input' => $thisIsRepeater ? null : $currInput,
            'data'  => $data,
            'disable'   => $disable,
            'require'   => $require,
            'repeater' => $thisIsRepeater,
            'lang'  => $lang
        ]);
    }

    public static function date($name, $desc, $format = "DD.MM.YYYY", $timestump = false, $require = true){
        global $currInput;
        $value = isset($currInput) && isset($currInput[$name]) ? $currInput[$name] :  "";
        if($timestump && $value){
            $value = \Date::createFromTimestamp($value)->format($timestump);
        }

        return view('admin.form.input.date', [
            "name"  => $name,
            "desc"  => $desc,
            "placeholder"   => $desc,
            'input' => $value,
            'format'    => $format,
            'timestump'    => $timestump,
            'require'   => $require
        ]);
    }

    public static function chosen($name, $desc, $table, $var = "title", $max = false, $where = false, $require = true){
        global $currInput;
        global $thisIsRepeater;
        if(isset($currInput) && isset($currInput[$name])){
            try{
                $currInput[$name] = explode(',', $currInput[$name]);
            }catch (\Exception $e){dd($currInput, $e);}
        }

        if(gettype($table) == 'string'){
            $data = \DB::table($table);
            if($where){
                $data = $data->where($where[0], $where[1]);
            }
            $data = $data->get();
        }else{
            $data = $table;
        }



        return view('admin.form.input.chosen', [
            "name"  => $name,
            "desc"  => $desc,
            'input' => $thisIsRepeater ? null : $currInput,
            'data'  => $data,
            'var'   => $var,
            'max'   => $max,
            'require'   => $require
        ]);
    }

    public static function image($name, $desc, $width = 0, $height = 0, $max = 1, $require = true){
        global $currInput;
        global $thisIsRepeater;
        return view('admin.form.input.image', [
            "name"  => $name,
            "desc"  => $desc,
            'input' => $thisIsRepeater ? null : $currInput,
            "width" => $width,
            "height"    => $height,
            "rep"   => $thisIsRepeater,
            "max"   => $max,
            'require'   => $require
        ]);
    }

    public static function hide($name, $val=false){
        global $currInput;
        global $thisIsRepeater;
        if($val) $currInput[$name] = $val;

        return view('admin.form.input.hidden', [
            "name"  => $name,
            'input' => $thisIsRepeater ? null : $currInput
        ]);
    }

    public static function textarea($name, $desc, $require = true, $lang = true){
        global $currInput;
        global $thisIsRepeater;

        return view('admin.form.input.text', [
            "name"  => $name,
            "desc"  => $desc,
            "placeholder"   => $desc,
            'input' => $thisIsRepeater ? null : $currInput,
            'require'   => $require,
            'lang'  => $lang
        ]);
    }

    public static function wys($name, $desc, $require = true, $repeat = false){
        global $currInput;
        global $thisIsRepeater;

        return view('admin.form.input.wys', [
            "name"  => $name,
            "desc"  => $desc,
            "placeholder"   => $desc,
            'input' => $thisIsRepeater ? null : $currInput,
            'repeat'   => $repeat,
            'require'   => $require
        ]);
    }
}