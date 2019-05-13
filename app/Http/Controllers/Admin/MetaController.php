<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 18.04.2017
 * Time: 13:04
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AdminController;
use App\Model\Meta;
use Illuminate\Http\Request;

class MetaController extends AdminController {
    public function metaList($type){
        $data = Meta::getType($type);
        return view('admin.meta.list', ['data'=>$data, 'type'=>$type]);
    }

    public function metaEdit($type,$id){
        global $currInput;
        if($id != 0){
            $currInput = Meta::getOne($id)->toArray();
        }
        return view('admin.meta.edit', ['type'=>$type]);
    }

    public function metaSave($type, Request $r){
        $i = $r->input();
        $i['type'] = $type;
        $i['sort'] = intval($i['sort']);
        Meta::updateRecord($i);
        return redirect('/superuser/meta/'.$type);
    }

    public function delete($id){
        Meta::remove($id);
        return redirect()->back();
    }


    public static function name($type){
        switch ($type){
            case 'cat': return 'Категории';
            case 'color': return 'Цвета';
            case 'section': return 'Разделы';
            case 'size': return 'Размеры';
            case 'tags': return 'Теги для блога';
            case 'footer': return 'Футер';
            case 'menu': return 'Меню';
        }
        return false;
    }
}