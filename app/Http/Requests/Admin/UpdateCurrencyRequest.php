<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrencyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = (int) $this->route('id');

        return [
            'name'          => ['required', 'string', 'max:100'],
            'code'          => ['required', 'string', 'max:10', 'unique:currencies,code,'.$id],
            'symbol'        => ['required', 'string', 'max:10'],
            'exchange_rate' => ['required', 'numeric', 'min:0.000001'],
            'is_active'     => ['nullable'],
            'is_default'    => ['nullable'],
        ];
    }
}
