<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jek
 * Date: 18.01.2017
 * Time: 20:16
 */

namespace App\Http\Controllers;


class TemplateController extends Controller
{
    public function index($link){
        $link = preg_replace('/.html$/i',"",$link);
        $link = preg_replace('/\//i',".",$link);
        //dd($link);
        switch ($link){
            case 'template.parts.head': return $this->head($link); break;
        }
        return view($link);
    }

    public function head($link){
        return view($link);
    }
}