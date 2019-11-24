<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditCategory extends FormRequest
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
            "uuid"=>"required|exists:categories,uuid",
            "label"=>"required|string|max:64",
            "description"=>"required|string",
            "picture"=>"required|exists:pictures,id_p",
            "color"=>"required|string|max:6",
            "disabled"=>"required|boolean"
        ];
    }
}
