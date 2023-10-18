<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScannerStoreRequest extends FormRequest
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
            'name' => ['required', 'max:255', 'string'],
            'amount' => ['required', 'numeric'],
            'mode' => ['required', 'in:pay,setup'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
}
