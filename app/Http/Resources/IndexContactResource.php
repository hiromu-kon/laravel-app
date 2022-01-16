<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

/**
 * 問い合わせ一覧リソースクラス
 * 
 * Class IndexContactResource
 * @package App\Http\Resources
 */
class IndexContactResource extends JsonResource
{

    /**
     * The 'contact' wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'contacts';

    /**
     * リソースを配列へ変換
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'content'    => Str::substr($this->content, 0, 50),
            'contact_at' => $this->contact_at
        ];
    }
}
