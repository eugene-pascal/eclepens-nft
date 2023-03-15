<?php

namespace App\Mail;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignupCompletedNotifyAdmin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var App\Models\Member
     */
    public $member;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
        $this->subject = __('mail.member.signup.title', ['site'=>env('APP_NAME')]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $link = route('member.validate.email', ['code'=>$this->member->remember_token]);
        return $this->view('mail.member.signup_notify_admin')
            ->with([
                'metaTitle' => $this->subject,
                'link' => $link
            ]);
    }
}
