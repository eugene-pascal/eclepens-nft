<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendMail;
use App\Jobs\SendMailResetPassword;
use App\Models\Member;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function newPassword(Request $request)
    {
        $this->validateEmail($request);
        $credentials = $this->credentials($request);

        $member = Member::where('email', $credentials['email'])
            ->where('status', \Config::get('constants.status.active'))
            ->first();

        if (!isset($member)) {
            $response = 'No email found';
            if ($request->wantsJson()) {
                throw ValidationException::withMessages([
                    'email' => [trans($response)],
                ]);
            }
            return redirect()
                ->route('member.login', ['tab'=>'forgot'])
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans($response)]);
        }

        $newPassword = str_random(8);
        $member->update(['password'=>Hash::make($newPassword)]);

        SendMailResetPassword::dispatch($member,['new_password'=>$newPassword])->onQueue('emails');

        return redirect()->route('member.login', ['tab'=>'signin'])
            ->with(['successOnResetPassword' => true]);

    }
}
