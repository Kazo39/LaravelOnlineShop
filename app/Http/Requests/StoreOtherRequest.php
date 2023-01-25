<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOtherRequest extends FormRequest
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
            'name' => ['required', 'max:50'],
            'type' => ['required', 'max:50'],
            'price' => ['required' , 'numeric', 'max:4'],
            'description' => ['required', 'max:200'],
            'product_photo' => ['required', 'file', 'image', 'max:2000']
        ];
    }
}
