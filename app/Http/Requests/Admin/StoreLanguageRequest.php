<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreLanguageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:100'],
            'code'        => ['required', 'string', 'max:10', 'unique:languages,code'],
            'native_name' => ['nullable', 'string', 'max:100'],
            'direction'   => ['required', 'in:ltr,rtl'],
            'is_active'   => ['nullable'],
            'is_default'  => ['nullable'],
        ];
    }
}
