<?php

namespace App\Jobs;

use App\Mail\PartnerAddedMemberNotify;
use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyAdminAboutPartnerActions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Member
     */
    protected $member;

    /*
     * @var array
     */
    protected $params = [];

    /**
     * NotifyAdminAboutPartnerActions constructor.
     *
     * @param Member $member
     * @param array $params
     */
    public function __construct(Member $member, $params=[])
    {
        $this->member = $member;
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to(env('ADMIN_EMAIL'))
            ->send(new PartnerAddedMemberNotify($this->member, $this->params));
    }
}
