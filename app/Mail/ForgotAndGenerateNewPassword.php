<?php

namespace App\Mail;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotAndGenerateNewPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var App\Models\Member
     */
    public $member;

    /**
     * @var array
     */
    protected $params = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Member $member, $params=[])
    {
        $this->member = $member;
        $this->params = $params;
        $this->subject = __('mail.member.forgot.title_reset', ['site'=>env('APP_NAME')]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $link = route('member.login');
        return $this->view('mail.member.generate_new_password')
            ->with([
                'metaTitle' => $this->subject,
                'link' => $link,
                'newPassword' => (!empty($this->params['new_password']) ? $this->params['new_password'] : '')
            ]);
    }
}
