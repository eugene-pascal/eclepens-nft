<?php

namespace App\Jobs;

use App\Mail\ForgotAndGenerateNewPassword;
use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailResetPassword implements ShouldQueue
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
     * Create a new job instance.
     *
     * @return void
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
        Mail::to($this->member->email)
            ->send(new ForgotAndGenerateNewPassword($this->member, $this->params));
    }
}
