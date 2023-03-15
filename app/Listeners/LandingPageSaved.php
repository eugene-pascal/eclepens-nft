<?php

namespace App\Listeners;

use App\Events\LandingPageSaved as LandingPageSavedEvent;

class LandingPageSaved
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\LandingPageSaved $event
     * @return mixed
     */
    public function handle(LandingPageSavedEvent $event)
    {
        app('log')->info($event->lp);
    }
}