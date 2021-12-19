<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ContactRequest;
use App\Http\Resources\Contact\Contact as ContactResource;
use App\Models\Contact;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

/**
 * 問い合わせコントローラー
 *
 * Class ContactController
 * @package App\Http\Controllers\Api
 */
class ContactController extends ApiController
{

    /**
     * チェックから除外するリファラを配列に格納
     * 
     * @var array
     */
    protected $referer = [
        //
    ];

    /**
     * 問い合わせを保存
     *
     * @param  ContactRequest $request
     * @return ContactResource|\Illuminate\Http\JsonResponse
     */
    public function store(ContactRequest $request)
    {

        if (Contact::exists($request)) {

            return $this->respondConflict("既に問い合わせが存在します。");
        }

        if (!in_array($request->headers->get("referer"), $this->referer)) {

            return $this->respondForbidden("アクセス権限がありません。");
        }

        try {

            $query = array_merge($request->validated(), array(
                "ip_address" => $request-> ip(),
                "contact_at" => date("Y-m-d H:i:s")
            ));

            $contact = new Contact($query);
            $contact->save();
        } catch (QueryException $e) {

            return $this->respondInvalidQuery($e->getMessage());
        }

        Mail::to($request->email)->send(new ContactMail($request->all()));

        return new ContactResource($contact);
    }
}
