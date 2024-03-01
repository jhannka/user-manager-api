<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'phone_number' => 'required|numeric|digits_between:1,10',
            'identification_card' => 'required|string|max:11',
            'birth_date' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'city_code' => 'required|numeric|digits_between:1,6',
            'departament' => 'required|numeric|digits_between:1,6',
        ];
    }

}
