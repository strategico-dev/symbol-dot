<?php


namespace App\Traits;

use Illuminate\Http\JsonResponse;

/**
 * @property int $expiresTime
 */
trait Tokenizer
{
    /**
     * @var int
     */
    private $expiresTime = 60;

    /**
     * @param string $token
     * @return JsonResponse
     */
    public function tokenize(string $token)
    {
        return response()->json([
            'access_token'  => $token,
            'token_type'    => 'bearer',
            'expires_in'    => auth()->factory()->getTTL() * $this->expiresTime
        ]);
    }
}
