<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Step2Request extends FormRequest
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
        'weight' => [
    'required',
    'numeric',
    'regex:/^\d{1,4}(\.\d{1})?$/'
],

'target_weight' => [
    'required',
    'numeric',
    'regex:/^\d{1,4}(\.\d{1})?$/'
],
    ];
}
public function messages()
{
    return [
        'weight.required' => '現在の体重を入力してください',
        'target_weight.required' => '目標体重を入力してください',
    ];
}
}