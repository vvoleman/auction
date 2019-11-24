<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategory extends FormRequest
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
            "label"=>"required|string|max:64",
            "description"=>"required|string",
            "picture_id"=>"required|exists:pictures,id_p",
            "color"=>"required|min:6|max:6",
            "disabled"=>"required|boolean"
        ];
    }
}
