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
     * 開始日から終了日までのお問い合わせを取得
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param  $startDate
     * @param  $endDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTermBetween($query, $startDate, $endDate)
    {
 
        $startDate = new Carbon($startDate);
        $endDate   = new Carbon($endDate);

        return $query
            ->when($startDate, function($query, $startDate) {
                return $query->where('contact_at', '>', $startDate->format('Y-m-d H:i:s'));
            })
             ->when($endDate, function($query, $endDate) {
                return $query->where('contact_at', '<', $endDate->format('Y-m-d H:i:s'));
            });
    }
}
