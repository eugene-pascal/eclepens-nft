<?php

namespace App\Mail;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PartnerAddedMemberNotify extends Mailable
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
        $this->subject = __('mail.admin.partner.added_member.title', ['site'=>env('APP_NAME')]);
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.partner.added_member_notify_admin')
            ->with([
                'metaTitle' => $this->subject,
                'partnerName' => (!empty($this->params['partnerName']) ? $this->params['partnerName'] : ''),
                'memberName' => (!empty($this->params['memberName']) ? $this->params['memberName'] : '')
            ]);
    }
}
