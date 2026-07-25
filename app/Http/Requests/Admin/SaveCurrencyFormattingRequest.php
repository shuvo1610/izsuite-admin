<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveCurrencyFormattingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'symbol_position'    => ['required', 'in:left,right'],
            'decimal_separator'  => ['required', 'string', 'max:5'],
            'thousand_separator' => ['nullable', 'string', 'max:5'],
            'decimals'           => ['required', 'integer', 'min:0', 'max:8'],
        ];
    }
}
