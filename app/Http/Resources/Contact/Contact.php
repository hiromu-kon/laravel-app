<?php

namespace App\Http\Resources\Contact;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * 問い合わせリソースクラス
 *
 * Class Contact
 * @package App\Http\Resources\Contact
 */
class Contact extends JsonResource
{

    /**
     * リソースを配列へ変換
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            "id"         => $this->id,
            "name"       => $this->name,
            "email"      => $this->email,
            "content"    => $this->content,
            "ip_address" => $this->ip_address,
            "contact_at" => $this->contact_at,
        ];
    }
}
