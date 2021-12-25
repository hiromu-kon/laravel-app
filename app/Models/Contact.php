<?php

namespace App\Models;

use App\Exceptions\ConflictException;
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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "email",
        "content"
    ];

    /**
     * 問い合わせの存在チェック
     *
     * @param $contact
     * @return bool
     */
    public function isDuplicate($contact)
    {

        $exists = self::where("name", $contact->name)
            ->where("email", $contact->email)
            ->where("content", $contact->content)
            ->exists();

        if ($exists) {

            throw new ConflictException("既に問い合わせが存在します。");
        }

        return;
    }
}
