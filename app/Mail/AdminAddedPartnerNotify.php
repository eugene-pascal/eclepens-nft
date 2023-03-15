<?php

namespace App\Mail;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminAddedPartnerNotify extends Mailable
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
     * AdminAddedPartnerNotify constructor.
     * @param Member $member
     * @param array $params
     */
    public function __construct(Member $member, $params=[])
    {
        $this->member = $member;
        $this->params = $params;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message1 = '';
        if ('remove.partner.connection' === $this->params['action']) {
            $this->subject = __('mail.admin.partner.remove_member.title', ['site'=>env('APP_NAME')]);
            $message1 = __('mail.admin.partner.remove_member.message1', ['partnerName'=> '<strong>'.$this->params['partnerName'].'</strong>', 'memberName'=> '<strong>'.$this->member->getFullName().'</strong>']);
        }
        elseif ('approved.partner.connection' === $this->params['action']) {
            $this->subject = __('mail.admin.partner.approved_member.title', ['site'=>env('APP_NAME')]);
            $message1 = __('mail.admin.partner.approved_member.message1', ['partnerName'=> '<strong>'.$this->params['partnerName'].'</strong>', 'memberName'=> '<strong>'.$this->member->getFullName().'</strong>']);
        }
        elseif ('declined.partner.connection' === $this->params['action']) {
            $this->subject = __('mail.admin.partner.declined_member.title', ['site'=>env('APP_NAME')]);
            $message1 = __('mail.admin.partner.declined_member.message1', ['partnerName'=> '<strong>'.$this->params['partnerName'].'</strong>', 'memberName'=> '<strong>'.$this->member->getFullName().'</strong>']);
        }

        return $this->view('mail.partner.action_with_connection_by_admin_notify_partner')
            ->with([
                'metaTitle' => $this->subject,
                'message1' => $message1
            ]);
    }
}
