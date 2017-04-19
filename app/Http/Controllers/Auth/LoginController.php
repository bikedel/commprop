<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate()
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            // Authentication passed...
            return redirect('/home');
        }
    }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //  protected $redirectTo = '/home';

    protected function authenticated(Request $request, $user)
    {

        $username = Auth::user()->name;

        $useragent = request()->header('User-Agent');
        $ip        = request()->ip();
        activity("Auth")->withProperties(

            ['Ip' => $ip, 'user' => $username, 'UserAgent' => $useragent])->log('login ');

        //  if ($user->isAdmin()) {

        //     return redirect()->route('dashboard');
        //  }

        return redirect('/home');
    }

    protected function logout(Request $request)
    {

        $username = Auth::user()->name;

        activity("Auth")->withProperties(

            ['user' => $username])->log('logOut ');

        //  if ($user->isAdmin()) {

        //     return redirect()->route('dashboard');
        //  }
        Auth::logout();
        return redirect('/login');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // dd("here i am");

        $this->middleware('guest', ['except' => 'logout']);

    }

}
