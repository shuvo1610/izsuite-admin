<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RecruiterNotificationRequested
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public int $recruiterId,
        public string $type,
        public string $title,
        public string $message,
        public ?string $actionUrl = null,
        public array $data = [],
    ) {}
}
