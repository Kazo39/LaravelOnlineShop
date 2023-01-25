<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOtherRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'new_name' => ['required', 'max:50'],
            'new_price' => ['required', 'max:4'],
            'new_description' => ['required', 'max:200'],
            'new_type' => ['required', 'max:50'],
            'new_product_photo' => ['file', 'image', 'max:2000']
        ];
    }
}
