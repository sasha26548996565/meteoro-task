<?php

declare(strict_types=1);

namespace App\Http\Requests\Knife;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guest() == false;
    }

    public function rules(): array
    {
        return [
            'material' => 'required',
            'blade_length' => 'required',
            'handle' => 'required'
        ];
    }
}
