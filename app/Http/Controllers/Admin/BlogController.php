<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 16.05.2017
 * Time: 11:50
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Model\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller {
    public function All($type = 'news') {
        $data = Blog::getByType($type);
        return view('admin.blog.list', ['data' => $data, 'type' => $type]);
    }

    public function Edit($type, $mod, $id) {
        global $currInput;
        if ($id != 0) {
            $currInput = Blog::getSingle($id, [])->toArray();
            if(gettype($currInput['tags']) != 'array')
                $currInput['tags'] = json_decode($currInput['tags']);

            $currInput['tags'] = implode(',',$currInput['tags']);
        }

        if($mod == 'full'){
            return view('admin.blog.full', ['type'=>$type]);
        }
        return view('admin.blog.short', ['type'=>$type]);
    }

    public function Save(Request $r) {
        $i = $r->input();
        $i['tags'] = json_encode(array_filter(explode(',', $i['tags'])));
        Blog::updateRec($i['id'], $i);
        //dd($i);
        return redirect('/superuser/blog/'.$i['type']);
    }

    public function Delete($id) {
        Blog::remove($id);
        return redirect()->back();
    }

    public static function names($type){
        switch ($type){
            case 'news': return 'Новости';
            case 'articles': return 'Статьи';
            case 'reviews': return 'Обзоры';
        }
    }
}