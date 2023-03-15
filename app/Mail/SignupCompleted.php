<?php

namespace App\Mail;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignupCompleted extends Mailable
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

        if ($this->member->isPartner()) {
            $templateName = 'mail.member.signup_partner';
        } else {
            $templateName = 'mail.member.signup';
        }
        return $this->view($templateName)
            ->with([
                'metaTitle' => $this->subject,
                'link' => $link
            ]);
    }
}
