<?php

namespace App\Http\Controllers\Api;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\Contact\Contact as ContactResource;
use App\Exceptions\ForbiddenException;
use App\Exceptions\ModelQueryException;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;

/**
 * 問い合わせコントローラー
 *
 * Class ContactController
 * @package App\Http\Controllers\Api
 */
class ContactController extends Controller
{

    /**
     * チェックから除外するリファラを配列に格納
     * 
     * @var array
     */
    protected $referer = [
        //
        ""
    ];

    /**
     * 問い合わせを保存
     *
     * @param  ContactRequest $request
     * @return ContactResource|\Illuminate\Http\JsonResponse
     */
    public function store(ContactRequest $request, Contact $contact)
    {

        if (!in_array($request->headers->get("referer"), $this->referer, true)) {

            throw new ForbiddenException();
        }

        try {

            $contact = Contact::make()->fill($request->validated());
            $contact->isDuplicate($contact);
            $contact->ip_address = $request->ip();
            $contact->contact_at = now();
            $contact->save();
        } catch (QueryException $e) {

            throw new ModelQueryException($e->getMessage());
        }

        return $contact;
    }
}
