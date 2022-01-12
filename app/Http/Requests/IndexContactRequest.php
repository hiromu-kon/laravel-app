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

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得
     *
     * @return array
     */
    public function messages()
    {

        return [
            'start_date.date'            => '開始日には有効な日付を指定してください',
            'start_date.date_format'     => '開始日はY-m-dの形式で指定してください',
            'start_date.before_or_equal' => '開始日には、今日より前の日付を指定してください',
            'end_date.date'              => '終了日には有効な日付を指定してください',
            'end_date.date_format'       => '終了日はY-m-dの形式で指定してください',
            'end_date.before_or_equal'   => '終了日には、今日より前の日付を指定してください'
        ];
    }

    public function passedValidation()
    {

        $page         = $this->filled('page') ? $this->input('page') : 1;
        $start_exists = $this->filled('start_date');
        $end_exists   = $this->filled('end_date');
        $start        = $this->input('start_date');
        $end          = $this->input('end_date');

        if ($start_exists && $end_exists) {

            $start_date = $start < $end ? $start : $end;
            $end_date   = $start < $end ? $end   : $start;
        } else {

            $start_date = $start;
            $end_date   = $end;
        }

        $this->replace([
            'page'       => $page,
            'start_date' => $start_date,
            'end_date'   => $end_date
        ]);
    }
}
