<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            "imgs" => "nullable|array",
            "imgs.*" => 'nullable|mimes:jpeg,png,gif,svg|max:2048',
            'caption' => "required|string|max:5000"
        ];
    }
}