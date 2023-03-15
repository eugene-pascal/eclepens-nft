<?php

namespace App\Events;

use App\Models\LandingPage;
use Illuminate\Queue\SerializesModels;

class LandingPageSaved
{
    use SerializesModels;

    public $lp;

    /**
     * Create a new event instance.
     *
     * @param \App\User $user
     */
    public function __construct(LandingPage $lp)
    {
        $this->lp = $lp;
    }
}