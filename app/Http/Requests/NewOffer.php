<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewOffer extends FormRequest
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
            "name"=>"required|min:8|max:64",
            "type"=>"required|exists:offer_types,id_ot",
            "price"=>"required|numeric|min:0.01",
            "description"=>"required",
            "end_date"=>"required|date"
        ];
    }
}