<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
     * Verify and redirect users after login.
     *
     * @var string
     */
    public function verify(Request $request){
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        $remember_me  = ( !empty( $request->remember_me ) )? TRUE : FALSE;
    
        if(Auth::attempt($credentials)){
            $user = User::where(["username" => $credentials['username']])->first();
        
            Auth::login($user, $remember_me);
    
            return redirect(route('home'));
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        session(['url.intended' => url()->previous()]);
        $this->redirectTo = session()->get('url.intended');

        $this->middleware('guest')->except('logout');
    }

    /**
     * Logout and redirect users after logout.
     *
     * @return void
     */
    public function logout(Request $request){
        Auth::logout();
        return redirect(route('login'));
    }
}