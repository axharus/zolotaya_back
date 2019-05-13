<?php
/**
 * Created by PhpStorm.
 * User: Jek
 * Date: 22.05.2017
 * Time: 14:29
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Model\Comment;
use App\Model\SEO;
use Illuminate\Http\Request;

class CommentsController extends Controller {
    public function All() {
        $data = Comment::iAll();
        return view('admin.comments', ['data' => $data]);
    }

    public function Approve($id) {
        Comment::approve($id);
        return redirect()->back();
    }

    public function Delete($id) {
        Comment::remove($id);
        return redirect()->back();
    }
}