<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeightRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
{
    return [
        'date' => ['required', ],

        'weight' => [
            'required',
            'numeric',
            'regex:/^\d{1,4}(\.\d{1})?$/'
        ],

        'calories' => [
            'required',
            'numeric'
        ],

       'exercise_time' => ['required', 'date_format:H:i'],

        'exercise_content' => [
            'nullable',
            'max:120'
        ],
    ];
}

public function messages()
{
    return [
        // 日付
        'date.required' => '日付を入力してください',

        // 体重
        'weight.required' => '体重を入力してください',
        'weight.numeric' => '数字で入力してください',
        'weight.regex' => '小数点は1桁で入力してください',
        'weight.max' => '4桁までの数字で入力してください',

        // カロリー
        'calories.required' => '摂取カロリーを入力してください',
        'calories.numeric' => '数字で入力してください',

        // 運動時間
        'exercise_time.required' => '運動時間を入力してください',
        'exercise_time.date_format' => '00:00形式で入力してください',

        // 運動内容
        'exercise_content.max' => '120文字以内で入力してください',
    ];
}
}