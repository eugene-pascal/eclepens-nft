<?php

namespace App\Jobs;

use App\Mail\SignupCompleted;
use App\Mail\SignupCompletedNotifyAdmin;
use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailSignup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $member;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->member->email)
            ->send(new SignupCompleted($this->member));
        // Notify Admin
        Mail::to(env('ADMIN_EMAIL'))
            ->send(new SignupCompletedNotifyAdmin($this->member));
    }
}
