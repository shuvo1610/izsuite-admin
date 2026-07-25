<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status'      => ['required', 'in:open,in_progress,resolved,closed'],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ];
    }
}
