<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait JsonRespondController
{

    /**
     * @var int
     */
    protected $httpStatusCode = 200;

    /**
     * レスポンスのHTTPステータスコードを送信
     *
     * @return int
     */
    public function getHTTPStatusCode(): int
    {

        return $this->httpStatusCode;
    }

    /**
     * レスポンスのHTTPステータスコードを設定
     *
     * @param  int $statusCode
     * @return self
     */
    public function setHTTPStatusCode(int $statusCode): self
    {

        $this->httpStatusCode = $statusCode;

        return $this;
    }

    /**
     * 無効なクエリに対してエラーを送信
     *
     * @param  string $message
     * @return JsonResponse
     */
    public function respondInvalidQuery(?string $message = null): JsonResponse
    {

        return $this->setHTTPStatusCode(500)
            ->respondWithError($message);
    }

    /**
     * リクエストが不正なためエラーを送信
     *
     * @param  string $message
     * @return JsonResponse
     */
    public function respondBadRequest(?string $message = null): JsonResponse
    {

        return $this->setHTTPStatusCode(400)
            ->respondWithError($message);
    }

    /**
     * 不適切な認証に対してエラーを送信
     *
     * @param  string $message
     * @return JsonResponse
     */
    public function respondUnauthorized(?string $message = null): JsonResponse
    {

        return $this->setHTTPStatusCode(401)
            ->respondWithError($message);
    }

    /**
     * 権限不足に対してエラーを送信
     *
     * @param  string $message
     * @return JsonResponse
     */
    public function respondForbidden(?string $message = null): JsonResponse
    {

        return $this->setHTTPStatusCode(403)
            ->respondWithError($message);
    }

    /**
     * 対象が見つからないためエラーを送信
     *
     * @param  string $message
     * @return JsonResponse
     */
    public function respondNotFound(?string $message = null): JsonResponse
    {

        return $this->setHTTPStatusCode(404)
            ->respondWithError($message);
    }

    /**
     * 対象が競合しているためエラーを送信
     *
     * @param  string $message
     * @return JsonResponse
     */
    public function respondConflict(?string $message = null): JsonResponse
    {

        return $this->setHTTPStatusCode(409)
            ->respondWithError($message);
    }


    /**
     * エラー時にレスポンスを送信
     *
     * @param  string $message
     * @return JsonResponse
     */
    public function respondWithError(?string $message = null): JsonResponse
    {

        return $this->respond([
            "error" => [
                "message" => $message ?? config("api.error_codes." . $this->getHTTPStatusCode()),
                "code"    => $this->getHTTPStatusCode(),
            ],
        ]);
    }

    /**
     * JSONを送信
     *
     * @param  array $data
     * @return JsonResponse
     */
    public function respondWithOK(array $data)
    {

        return $this->setHTTPStatusCode(200)
            ->respond($data);
    }

    /**
     * JSONを送信
     *
     * @param  array $data
     * @param  array $headers
     * @return JsonResponse
     */
    public function respond(array $data, array $headers = []): JsonResponse
    {

        return response()->json($data, $this->getHTTPStatusCode(), $headers);
    }
}
