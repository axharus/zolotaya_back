<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;

class LoginController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    private $mailer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function username() {
        return 'email';
    }

    public function __construct(Mailer $mailer, Request $request) {
        parent::__construct($request);
        $this->mailer = $mailer;
        //$this->middleware('guest', ['except' => 'logout']);
    }

    public function check() {
        if (\Auth::check()){
            response()->json(true, 201);
        }
        return response()->json(false, 201);
    }

    protected function validator(array $data) {
        return Validator::make($data, [
            'login' => 'required|exists:users,email',
            'password' => 'required',
        ]);
    }

    protected function validatorEmail(array $data) {
        return Validator::make($data, [
            'email' => 'required|email|exists:users,email',
        ]);
    }

    public function login(Request $request) {
        $labels = [
            'login' => trans('m.E-mail'),
            'password' => trans('m.Проль')
        ];
        $valid = self::validator($request->input());
        $valid->setAttributeNames($labels);

        if ($valid->fails()) {
            return response()->json($valid->messages(), 201);
        }

        // TODO: refactor
        $credentials = $request->only('login', 'password');
        $credentials['email'] = $credentials['login'];
        unset($credentials['login']);

        try {
            if (!$token = \JWTAuth::attempt($credentials,  ['exp' => date('U', strtotime('+2 week'))])) {
                if ($this->hasTooManyLoginAttempts($request)) {
                    $this->fireLockoutEvent($request);
                    return response()->json(false, 201);
                }
                $this->incrementLoginAttempts($request);
                return response()->json(["password" => [trans("m.Пароль введен не корректно")]], 201);
            }
        } catch (JWTException $e) {
            return response()->json(["error" => ['Could not create token']], 201);
        }

        return response()->json($token, 201);
    }

    public function loginLogin(Request $request) {

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }


        $user = User::getUserByEmail($request->login);
        if (\Hash::check($request->password, $user->password)) {
            \Auth::login($user);
            return redirect()->back();
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        return redirect()->back();
    }

    public function repassword(Request $request) {
        $labels = [
            'email' => "E-mail"
        ];

        $valid = self::validatorEmail($request->input());
        $valid->setAttributeNames($labels);

        if ($valid->fails()) {
            return json_encode($valid->messages());
        }

        $pass = User::changePasswordUserByEmail($request->email);
        $message = trans("m.Ваш новый пароль") . ' : ' . $pass;
        $this->mailer->raw($message, function (Message $m) use ($request) {
            $m->to($request->email)->subject(trans('m.Изменение пароля'));
        });

        return json_encode(true);
    }


}
