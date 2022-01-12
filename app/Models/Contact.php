<?php

namespace App\Models;

use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use App\Exceptions\ConflictException;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'name',
        'email',
        'content'
    ];


    protected static function boot()
    {

        parent::boot();
        static::created(function($contact) {
            Mail::to($contact->email)->send(new ContactMail($contact));
        });
    }

    /**
     * 問い合わせの存在チェック
     *
     * @param $contact
     * @return bool
     */
    public function isDuplicate($contact)
    {

        $exists = self::where([['name', $contact->name], ['email', $contact->email], ['content', $contact->content]])->exists();

        if ($exists) {

            throw new ConflictException('既に問い合わせが存在します。');
        }

        return;
    }

    /**
     * 開始日よりも未来のお問い合わせ日を取得
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param  $start_date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStartDate($query, $start_date)
    {
 
        $date = new Carbon($start_date);

        return $query->where('contact_at', '>', $date->format('Y-m-d H:i:s'));
    }

    /**
     * 終了日よりも過去のお問い合わせ日を取得
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param $end_date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEndDate($query, $end_date)
    {

        $date = new Carbon($end_date);

        return $query->where('contact_at', '<', $date->format('Y-m-d H:i:s'));
    }
}
