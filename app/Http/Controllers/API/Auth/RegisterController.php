<?php

namespace App\Http\Controllers\API\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $mailer;

    public function __construct(Mailer $mailer, Request $request)
    {
        parent::__construct($request);
        $this->middleware('guest');
        $this->mailer = $mailer;
    }


    protected function validator(array $data){
        return Validator::make($data, [
            'email' => 'required|unique:users|email',
            'password'  => 'required|same:repeatPassword|min:8',
            'name'  => 'required',
            'second'  => 'required',
            'agreement'=>"required"
        ]);
    }

    public function registration(Request $request){
        $labels = [
            'gender'=> trans('m.Пол'),
            'email'=> "E-mail",
            'name'=> trans('m.Имя'),
            'second'=> trans('m.Фамилия'),
            'password'=> trans('m.Проль'),
            'repeatPassword'=> trans('m.Повторите пароль'),
            'agreement' => trans('m.Пользовательское соглашение')
        ];

        $valid = self::validator($request->input());
        $valid->setAttributeNames($labels);

        if($valid->fails()){
            return response()->json($valid->messages(), 201);
        }

        $data = $request->input();

        //$data['activated'] = hash_hmac('sha256', str_random(40), config('app.key'));

        $user = User::newUser($data);
        if ($user === false) return response()->json(false, 201);

        //\Auth::loginUsingId($user['id']);
        //$user = User::getUserByLogin($request->login);

//        $link = env('FRONT').'/auth/'.$data['activated'];
//        $message = sprintf(trans("m.Активируйте ваш аккаунт перейдя по ссылке").' <a href="%s">%s</a>', $link, $link);
//        $this->mailer->raw($message, function (Message $m) use ($user) {
//            $m->to($user->email)->subject(trans('m.Активация аккаунта'));
//        });

        return response()->json(true, 201);
    }

    public function activate($token){
        if ($user = User::activate($token)){
            $this->guard()->login($user);
        }
        return redirect(env('FRONT').'/?token='.JWTAuth::fromUser($user));
    }
}
