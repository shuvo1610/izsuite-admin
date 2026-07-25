<?php

namespace App\Providers;

use App\Events\RecruiterNotificationRequested;
use App\Listeners\QueueRecruiterNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Event::listen(RecruiterNotificationRequested::class, QueueRecruiterNotification::class);
    }
}
