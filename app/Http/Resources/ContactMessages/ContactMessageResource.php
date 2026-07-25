<?php

namespace App\Http\Resources\ContactMessages;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactMessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $badge = $this->admin_reply ? [
            'label'   => 'Replied',
            'variant' => 'success',
        ] : null;

        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'email'        => $this->email,
            'subject'      => $this->subject,
            'message'      => $this->message,
            'status'       => $this->status,
            'badge'        => $badge,
            'reply'        => $this->admin_reply ? [
                'message'    => $this->admin_reply,
                'replied_at' => $this->replied_at?->toIso8601String(),
                'replied_by' => $this->replier?->name,
            ] : null,
            'submitted_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
