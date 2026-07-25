<?php

namespace App\Services\Api\ContactMessages;

use App\Models\ContactMessage;
use App\Models\User;
use App\Repositories\ContactMessageRepository;
use App\Services\ActivityLogService;

class ContactMessageService
{
    public function __construct(
        protected ContactMessageRepository $contactMessageRepository,
    ) {}

    public function create(array $data, ?User $user = null): ContactMessage
    {
        $contactMessage = $this->contactMessageRepository->create([
            'user_id' => $user?->id,
            'name'    => $data['name'],
            'email'   => strtolower($data['email']),
            'subject' => $data['subject'],
            'message' => $data['message'],
            'status'  => 'new',
        ]);

        ActivityLogService::record('created', "Submitted contact message #{$contactMessage->id}", $contactMessage);

        return $contactMessage;
    }
}
