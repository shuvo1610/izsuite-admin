<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price'       => ['nullable', 'numeric', 'min:0'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:2048'],
            'category'    => ['nullable', 'string', 'max:255'],
            'status'      => ['required', 'in:active,inactive,pending'],
            'is_active'   => ['sometimes', 'boolean'],
        ];
    }
}
