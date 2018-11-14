<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Faker\Provider\File;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
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



    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    protected function credentials(Request $request)
    {
        return ['email' => $request->{$this->username()}, 'password' => $request->password, 'active' => 1];
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            \Session::put('usuario_id', $this->guard()->user()->id);
            \Session::put('usuario_nombre', $this->guard()->user()->name);
            \Session::put('usuario_email', $this->guard()->user()->email);
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        Session::remove('lastActivityTime');
        \Auth::logout();

        return redirect('/');
    }
}
