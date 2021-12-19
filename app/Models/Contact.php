<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 問い合わせモデル
 *
 * Class Contact
 * @package App\Models
 */
class Contact extends Model
{

    /**
     * 複数代入しない属性
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 問い合わせの存在チェック
     *
     * @param $request
     * @return bool
     */
    public static function exists($request): bool
    {

        return self::where("name", $request->name)
            ->where("email", $request->email)
            ->where("content", $request->content)
            ->exists();
    }
}
