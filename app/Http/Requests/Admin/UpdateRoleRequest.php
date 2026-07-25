<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = (int) $this->route('id');

        return [
            'name'          => ['required', 'string', 'max:255', 'unique:roles,name,'.$id],
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['string'],
        ];
    }
}
