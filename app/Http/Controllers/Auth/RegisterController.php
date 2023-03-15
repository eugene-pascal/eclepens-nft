<?php

namespace App\Http\Controllers\Auth;

use App\Enums\MemberTypeAccount;
use App\Enums\UserStatus;
use App\Jobs\SendMailSignup;
use App\Models\Member;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

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
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new member account
     */
    public function createMember(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members',
            'password' => 'required|string|min:6',
            'type_account' => 'required',
        ]);

        $data = $request->except(['cpassword', '_token', 'match_email_url', 'agree']);
        $typeAccount = $data['type_account'];

        $member = Member::create(
            array_merge($data, [
                'password' => Hash::make($request->password),
                'status' => UserStatus::INACTIVE,
                'description' => ''
            ])
        );
        $member->forceFill([
            'remember_token' => hash('sha256', Str::random(60))
        ])->save();

        SendMailSignup::dispatch($member)->onQueue('emails');

        return redirect()->route('member.login', ['tab'=>'signin'])
            ->with(['successOnCreate' => true]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function matchEmail(Request $request)
    {
        $isEmailExist = (bool)Member::where('email',$request->email)->count();
        return response()->json([
            'valid' => !$isEmailExist
        ]);
    }

    /**
     * @param $code
     */
    public function validateEmail($code)
    {
        $member = Member::where('remember_token',$code)
            ->where('status', \Config::get('constants.status.inactive'))
            ->first();
        if (!$member) {
            abort(404);
        }
        $result = $member->update(['status'=>\Config::get('constants.status.active')]);
        return redirect()->route('member.login', ['tab'=>'signin'])
            ->with(['successOnEmailValidated' => (bool)$result]);
    }
}
