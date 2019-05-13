<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jek
 * Date: 25.07.2016
 * Time: 14:43
 */

namespace App\Helper;


use App\Model\Comments;

class Comment{

    public static function comments($rel){
        if(\Auth::check()){
            return view('public.template.comment.tp', [
                "user"  => \Auth::user(),
                "comments"  => Comments::getByRelated(\Request::url()),
                'rel'   => $rel
            ]);
        }
        return view('public.template.comment.auth');
    }

    public static function webComment($id){
         return view('public.template.comment.webinar',[
             "id"   => $id
         ]);
    }

    public static function cab($related){
        return view('public.template.comment.cabTemplate', [
            'related'   =>$related
        ]);
    }

}
