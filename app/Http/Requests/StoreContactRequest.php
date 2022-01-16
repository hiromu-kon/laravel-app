<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

/**
 * 問い合わせ保存リクエストクラス
 *
 * Class StoreContactRequest
 * @package App\Http\Requests
 */
class StoreContactRequest extends ApiRequest
{

    /**
     * 認可されているかを判定
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * バリデーションルールを返す
     *
     * @return array
     */
    public function rules()
    {

        return [
            'name' => [
                'required',
                'max:50'
            ],
            'email' => [
                'required',
                'max:255',
                'email:strict,dns,spoof'
            ],
            'content' => [
                'required',
                'max:1000'
            ]
        ];
    }

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得
     *
     * @return array
     */
    public function messages()
    {

        return [
            'name.required'    => '名前は必須項目です',
            'name.max'         => '名前は50文字以内で入力してください',
            'email.required'   => 'メールアドレスは必須項目です',
            'email.max'        => 'メールアドレスは255文字以内で入力してください',
            'content.required' => '問い合わせ内容は必須項目です',
            'content.max'      => '問い合わせ内容は1000文字以内で入力してください'
        ];
    }
}
