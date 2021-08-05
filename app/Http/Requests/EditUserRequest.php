<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'numeric',
            'fullname' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'min:10']
        ];
    }
}
