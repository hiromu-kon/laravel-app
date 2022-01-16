<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

/**
 * 問い合わせ一覧リクエストクラス
 *
 * Class IndexContactRequest
 * @package App\Http\Requests
 */
class IndexContactRequest extends ApiRequest
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
            'start_date' => ['date', 'date_format:Y-m-d', 'before_or_equal:today'],
            'end_date'   => ['date', 'date_format:Y-m-d', 'before_or_equal:today']
        ];
    }

    public function passedValidation()
    {

        if($this->start_date && $this->end_date) {
            $array = [$this->start_date, $this->end_date];
            sort($array);
            [$startDate, $endDate] = $array;

            $this->replace([
                'startDate' => $startDate,
                'endDate'   => $endDate,
            ]);
        }
    }
}
