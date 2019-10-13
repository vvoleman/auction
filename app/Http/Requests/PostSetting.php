<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostSetting extends FormRequest
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
            "firstname"=>"required|min:2|max:32",
            "surname"=>"required|min:2|max:64",
            "region_id"=>"required|exists:regions,id_r"
        ];
    }

    public function messages(){
        return [
            "firstname.required"=>"Jméno musí být vyplněno",
            "firstname.min"=>"Minimální délka jména jsou 2 znaky",
            "firstname.max"=>"Maximální délka jména je 64 znaků",
            "surname.required"=>"Příjmení musí být vyplněno",
            "surname.min"=>"Minimální délka příjmení jsou 2 znaky",
            "surname.max"=>"Maximální délka příjmení je 64 znaků",
            "region_id.required"=>"Chybějící údaj (kraj)",
            "region_id.exists"=>"Neplatný údaj (kraj)"
        ];
    }
}
