<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Api共通リクエストクラス
 *
 * Class ApiRequest
 * @package App\Http\Requests
 */
abstract class ApiRequest extends FormRequest
{

    /**
     * バリデーション失敗時のハンドリング
     *
     * @param  Validator $validator
     * @return void
     * @throw HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {

        $data = [
            'error' => [
                'message' => $validator->errors()->toArray(),
                'code'    => 422,
            ],
        ];

        throw new HttpResponseException(response()->json($data, 422));
    }
}
