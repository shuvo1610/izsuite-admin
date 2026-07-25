<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SavePlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'                          => ['required', 'string', 'max:100'],
            'plan_for'                      => ['required', 'in:recruiter,candidate'],
            'billing_type'                  => ['required', 'in:monthly,yearly'],
            'description'                   => ['nullable', 'string', 'max:500'],
            'monthly_price'                 => ['nullable', 'numeric', 'min:0'],
            'yearly_price'                  => ['nullable', 'numeric', 'min:0'],
            'trial_days'                    => ['nullable', 'integer', 'min:0'],
            'job_postings_limit'            => ['nullable', 'integer', 'min:0'],
            'ai_screenings_limit'           => ['nullable', 'integer', 'min:0'],
            'team_members_limit'            => ['nullable', 'integer', 'min:0'],
            'features'                      => ['nullable', 'string'],
            'is_active'                     => ['nullable'],
            'is_featured'                   => ['nullable'],
            'sort_order'                    => ['nullable', 'integer', 'min:0'],
            'providers'                     => ['nullable', 'array'],
            'providers.*.provider'          => ['required_with:providers', 'string'],
            'providers.*.interval'          => ['required_with:providers', 'in:monthly,yearly'],
            'providers.*.provider_price_id' => ['nullable', 'string'],
        ];
    }
}
