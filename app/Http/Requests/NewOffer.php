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
            "name"=>"required|min:4|max:64",
            "type"=>"required|exists:offer_types,id_ot",
            "price"=>"required|numeric|min:0.01",
            "description"=>"required",
            "category"=>"required|integer|exists:categories,id_c",
            "delivery"=>"required|integer|exists:delivery_types,id_dt",
            "payment"=>"required|integer|exists:payment_types,id_pt",
            'images_upl.*' => 'required|mimes:jpeg,png,jpg,gif,svg|max:8192',
            "currency"=>"required|exists:currencies,id_c",
            "_tags"=>"nullable|json"
        ];
    }
}
