<?php

namespace App\Listeners;

use App\Events\RecruiterNotificationRequested;
use App\Jobs\StoreRecruiterNotification;

class QueueRecruiterNotification
{
    public function handle(RecruiterNotificationRequested $event): void
    {
        StoreRecruiterNotification::dispatch(
            recruiterId: $event->recruiterId,
            type: $event->type,
            title: $event->title,
            message: $event->message,
            actionUrl: $event->actionUrl,
            data: $event->data,
        )->afterCommit();
    }
}
