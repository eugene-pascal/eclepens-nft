<?php

namespace App\Http\Controllers\Auth;

use App\Facades\Auth;
use DB;
use Cookie;
use App\Enums\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Member;
use App\Components\Encryption;
use Illuminate\Support\Str;

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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/cpanel';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $isMemberFlag = (bool)$request->get('_member',false);

        $this->validateLogin($request);

        $credentials = $request->only('email', 'password');

        if ($isMemberFlag) {
            $user = Member::where('email', $credentials['email'])
                ->where('status', \Config::get('constants.status.active'))
                ->first();
            $userType = isset($user) ? $user->type_account : \Config::get('constants.session.type.member');
        } else {
            $userType = \Config::get('constants.session.type.admin');
            $user = User::where('email', $credentials['email'])
                ->where('status', \Config::get('constants.status.active'))
                ->first();
        }
        if (!isset($user)) {
            return $this->sendFailedLoginResponse($request);
        }
        if (!Hash::check($credentials['password'], $user->password)) {
            return $this->sendFailedLoginResponse($request);
        }

        // remove all expired
        DB::table('users_session')->where('session_time', '<', time() - User::SESSION_LIVE)->delete();

        $session_key = DB::table('users_session')
             ->where('email', '=', $user->email)
             ->where('session_time', '>', time() - User::SESSION_LIVE)
             ->value('session_key');

        if (!isset($session_key)) {
            $session_key = $user->getSessionKey();
            DB::table('users_session')->insert(
                ['email' => $user->email, 'name' => $user->name, 'id' => $user->id, 'session_key'=>$session_key, 'session_time'=>time(), 'type'=>$userType]
            );
        }

        Cookie::queue(User::sessionName(), $session_key, 60*24);

        return redirect()->route('dashboard');   
    }

    /**
     * Handle a logout request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $routeName = Auth::user()->isAdmin() ? 'login' : 'member.login' ;
        return redirect()->route($routeName)->withCookie(Cookie::forget(User::sessionName()));
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Show the application's login form for member.
     *
     * @return \Illuminate\View\View
     */
    public function showMemberLoginForm()
    {
        return view('auth.member.login');
    }
}
