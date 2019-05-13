<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jek
 * Date: 21.07.2016
 * Time: 11:23
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Helper\Uploader;

class UploadController extends Controller{
    public function upload($width,$height,Request $r){
        $el = array_first($r->file());
        if(gettype($el) == "array")
            $el = array_first($el);

        $file = Uploader::go($el, $width, $height);
        return json_encode([
            'initialPreview'    =>  [\U::path($file)],
            'initialPreviewConfig' => [
                ['caption' => $file, 'width' => '120px', 'url' => '/superuser/ulpoad/delete', 'key' => $file],
            ],
            'append' => true
        ]);
    }

    public function delete(Request $r){
        $key = $r->input()["key"];
        if($key)
            Uploader::del($key);
        return json_encode("");
    }
}

