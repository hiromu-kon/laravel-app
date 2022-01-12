<?php

namespace App\Http\Controllers\Api;

use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\IndexContactRequest;
use App\Http\Resources\IndexContactResource;
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
        ''
    ];

    /**
     * 問い合わせを保存
     *
     * @param  StoreContactRequest $request
     * @return $contact
     */
    public function store(StoreContactRequest $request, Contact $contact)
    {

        if (!in_array($request->headers->get('referer'), $this->referer, true)) {

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

    /**
     * 問い合わせ一覧を取得
     *
     * @param  IndexContactRequest $request
     * @return \Illuminate\Http\Resources|JsonResponse
     */
    public function index(IndexContactRequest $request)
    {

        $page         = $request->has('page') ? $request->input('page') : 1;
        $start_date   = $request->input('start_date');
        $end_date     = $request->input('end_date');

        dd($start_date);
        $query = Contact::query()->when($start_date, function($query, $start_date) {
            return $query->startDate($start_date);
        });

        $query->when($end_date, function($query, $end_date) {
            return $query->endDate($end_date);
        })->get();

        return IndexContactResource::collection($query->paginate(10, ['*'], 'page', $page));
    }

    /**
     * 問い合わせ詳細を取得
     *
     * @param  Contact $contact
     * @return $contact
     */
    public function show(Contact $contact)
    {

        return $contact;
    }
}
