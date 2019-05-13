<?php
namespace App;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use App\Model\BaseModel;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'second', 'email', 'password', 'sex', 'activated', 'address', 'phone', 'photo', 'dispatch'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'activated',
    ];

    protected $casts = [
        'address' => 'array',
        'dispatch' => 'array'
    ];


    public static function fFilter($i){
        $self = new static();
        $out = [];
        foreach ($self->getFillable() as $item) {
            if(isset($i[$item])) $out[$item] = $i[$item];
        }
        return $out;
    }

    public static function updateUser($data){
        self::where('id', \Auth::user()->id)->update(self::fFilter($data));
    }


    public static function getSingle($id, $with, $select = ['*']){
        try{
            return self::where('id', $id)->select($select)->with($with)->firstOrFail();
        }catch (ModelNotFoundException $e){
            return false;
        }
    }


    public static function newUser($array)
    {
        try{
            $array['dispatch']=json_decode('{"sale": false, "seller": false, "allNews": true, "newNews": false, "userUpdate": false}');
            $input = self::fFilter($array);
            $input['password'] = \Hash::make($input['password']);
            return self::create($input);
        }catch (\Exception $e){
            return false;
        }
    }


    public static function activate($token){
        try{
            $user = self::where('activated',$token)->firstOrFail();
            $user->activated = true;
            $user->save();
            return $user;
        }catch (\Exception $e){
            return false;
        }
    }

    public static function getUserByEmail($login){
        try{
            return self::where('email',$login)->firstOrFail();
        }catch (\Exception $e){
            return false;
        }
    }

    public static function changePasswordUserByEmail($email){
        try{
            $user = self::where('email',$email)->firstOrFail();
            $pass = str_random(12);
            $user->password = \Hash::make($pass);
            $user->save();
            return $pass;
        }catch (\Exception $e){
            return false;
        }
    }

    public static function getPassHash(){
        return self::where('id', \Auth::user()->id)->firstOrFail()->password;
    }

    public static function setPassHash($hash){
        $user = self::where('id', \Auth::user()->id)->firstOrFail();
        $user->password = $hash;
        $user->save();
    }

    public static function all_users(){
        return self::whereNotIn('id', \H::admin())->get();
    }

    public static function all_admin(){
        return self::whereIn('id', \H::admin())->get();
    }
}
