<?php

namespace App\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Intervention\Image\Exception\NotFoundException;

class Config extends BaseModel{
    protected $table = 'config';
    public $timestamps = false;
    protected $fillable = 	[	'name'	,'value'];
//    protected $dateFormat = 'U';

    public static function val($configName, $lang = true){
        global $allConfig;

        if($lang) $configName .= "_".app()->getLocale();
        if(!$allConfig){
            $allConfig = self::iAll()->toArray();
        }
        $key = array_search($configName, array_column($allConfig, 'name'));
        if($key || $key === 0){
            return $allConfig[$key]["value"];
        }
        return false;
    }

    public static function setVal($val){

        foreach ($val as $name =>  $item) {
            try{
                $data = self::where('name', $name)->firstOrFail();
                $data->value = $item;
                $data->save();
            }catch(ModelNotFoundException $e){
                self::create([
                    'name'  => $name,
                    'value' => $item
                ]);
            }
        }

    }

}