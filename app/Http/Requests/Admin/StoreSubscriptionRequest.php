<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'recruiter_id'      => ['required', 'integer', Rule::exists('users', 'id')],
            'plan_id'           => ['required', 'integer', Rule::exists('plans', 'id')->where(fn ($query) => $query
                ->where('is_active', true))],
            'amount'            => ['nullable', 'numeric', 'min:0'],
            'start_date'        => ['nullable', 'date'],
            'next_renewal_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status'            => ['nullable', 'in:active,trial,pending,cancelled'],
        ];
    }
}
