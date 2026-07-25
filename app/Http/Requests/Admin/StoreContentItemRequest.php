<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreContentItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'section' => ['required', 'string', 'in:stats,features,how_it_works,testimonials,social_links,footer_columns'],
            'data'    => ['required', 'array'],
        ];
    }
}
