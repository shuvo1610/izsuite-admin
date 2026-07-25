<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveFaqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'question'   => ['required', 'string', 'max:255'],
            'answer'     => ['nullable', 'string'],
            'status'     => ['required', 'in:published,draft'],
            'sort_order' => ['nullable', 'integer'],
        ];
    }
}
