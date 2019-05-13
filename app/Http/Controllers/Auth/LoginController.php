<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
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
        $this->middleware('guest', ['except' => 'logout']);
    }

    protected function validator(array $data) {
        return Validator::make($data, [
            'login' => 'required|exists:users,email',
            'password' => 'required',
        ]);
    }


    public function form() {
        if(\Auth::check()) return redirect('/');
        return view('admin.login');
    }


    public function login(Request $request) {
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->form();
        }

        $labels = [
            'login' => trans('m.E-mail'),
            'password' => trans('m.Проль')
        ];

        $valid = self::validator($request->input());
        $valid->setAttributeNames($labels);

        if ($valid->fails()) {
            return $this->form()->withErrors($valid->messages());
        }

        // TODO: refactor
        $credentials = $request->only('login', 'password');
        $credentials['email'] = $credentials['login'];
        unset($credentials['login']);

        if (!\Auth::attempt($credentials, isset($request->remember))) {
            return $this->form()->withErrors(["password" => [trans("m.Пароль введен не корректно")]]);
        }

        $this->incrementLoginAttempts($request);
        return $this->form();
    }

}
