<?php
namespace App\Helper;
use Image;

class Uploader{
	public static function go($file,$width = null, $height = null,$dir = ""){
        $dir = self::dir().$dir;
		if ($file->isValid() &&
            (strtolower($file->getClientOriginalExtension()) == "jpg" ||
                strtolower($file->getClientOriginalExtension()) == "png" ||
                strtolower($file->getClientOriginalExtension()) == "jpeg")) {

			$filename = str_random(18).".".strtolower($file->getClientOriginalExtension());
			while (file_exists(base_path().$dir.$filename)) {
				$filename = str_random(18).".".strtolower($file->getClientOriginalExtension());
			}

			$file->move(base_path().$dir, $filename);

            if($width && isset(explode(",",$width)[1])){

                $width = explode(",",$width);
                $height = explode(",",$height);
                for($i = 0; $i < count($width); $i++){

                    $img = Image::make(base_path().$dir.$filename);
                    if($width[$i] || $height[$i]){
                        $img->fit($width[$i] == 0 ? null : $width[$i], $height[$i] == 0 ? null : $height[$i], function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                    if (!file_exists(base_path().$dir.$width[$i]."x".$height[$i])) {
                        mkdir(base_path().$dir.$width[$i]."x".$height[$i], 0777, true);
                    }
                    $img->save(base_path().$dir.$width[$i]."x".$height[$i].'/'.$filename);
                }
            }else{
                $img = Image::make(base_path().$dir.$filename);
                if($width || $height){
                    $img->fit($width == 0 ? null : $width, $height == 0 ? null : $height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }

                $img->save(base_path().$dir.$filename);
            }
            return $filename;
		}else{
			return false;
		}
	}


    public static function del($file, $dir = false){
        $dir = $dir ? $dir : base_path().self::dir();

        foreach( glob( $dir."*" ) as $filename )
            if(is_dir($filename))
                self::del($file, $filename.'/');

        foreach( glob( $dir.$file ) as $filename )
            unlink($filename);

    }

    public static function dir(){
        return  "/public/image/";
    }

    public static function path($v, $pre = ""){
        $pre = $pre ? $pre.'/' : "";
        if($a = json_decode($v))
            return url("/image/".$pre.$a[0]);
        return url("/image/".$pre.$v);
    }

}