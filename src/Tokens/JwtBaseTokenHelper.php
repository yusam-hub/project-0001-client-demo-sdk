<?php

namespace YusamHub\Project0001ClientDemoSdk\Tokens;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtBaseTokenHelper
{
    /**
     * @param object $payload
     * @param string $privateKey
     * @param string $alg
     * @param array $head
     * @return string
     */
    protected static function baseToJwt(
        object $payload,
        string $privateKey,
        string $alg,
        array $head = []
    ): string
    {
        $now = time();
        return JWT::encode(
            (array) $payload,
            $privateKey,
            $alg,
            null,
            $head
        );
    }

    /**
     * @param string $jwt
     * @return array
     */
    protected static function baseFromJwtAsHeads(string $jwt): array
    {
        list($headersB64, $payloadB64, $sig) = explode('.', $jwt);
        return (array) json_decode(base64_decode($headersB64), true);
    }

    /**
     * @param string $jwt
     * @param string $publicKey
     * @return array
     */
    protected static function baseFromJwtAsPayload(string $jwt, string $publicKey): array
    {
        $baseTokenHead = static::baseFromJwtAsHeads($jwt);
        return (array) JWT::decode($jwt, new Key($publicKey, $baseTokenHead['alg']??''));
    }
}