<?php

namespace YusamHub\Project0001ClientDemoSdk\Tokens;


use YusamHub\Project0001ClientDemoSdk\Heads\DemoTokenHead;
use YusamHub\Project0001ClientDemoSdk\Payloads\DemoTokenPayload;

class JwtDemoTokenHelper extends JwtBaseTokenHelper
{
    /**
     * @param int $appId
     * @param int $userId
     * @param string $deviceUuid
     * @param string $publicKeyHash
     * @param string $privateKey
     * @param int $expireSeconds
     * @param int $skewSeconds
     * @return string
     */
    public static function toJwt(
        int $appId,
        int $userId,
        string $deviceUuid,
        string $publicKeyHash,
        string $privateKey,
        int $expireSeconds = 3600,
        int $skewSeconds = 60,
    ): string
    {
        $now = time();

        $demoTokenPayload = new DemoTokenPayload();
        $demoTokenPayload->aid = $appId;
        $demoTokenPayload->uid = $userId;
        $demoTokenPayload->did = $deviceUuid;
        $demoTokenPayload->phs = $publicKeyHash;
        $demoTokenPayload->iat = ($now - $skewSeconds);
        $demoTokenPayload->exp = ($now + $expireSeconds);

        return static::baseToJwt(
            $demoTokenPayload,
            $privateKey,
            'RS256',
            (array) (new DemoTokenHead([
                'aid' => $demoTokenPayload->aid,
                'uid' => $demoTokenPayload->uid,
                'did' => $demoTokenPayload->did,
            ]))
        );
    }

    /**
     * @param string $jwt
     * @return DemoTokenHead
     */
    public static function fromJwtAsHeads(string $jwt): DemoTokenHead
    {
        return new DemoTokenHead(static::baseFromJwtAsHeads($jwt));
    }

    /**
     * @param string $jwt
     * @param string $publicKey
     * @return DemoTokenPayload
     */
    public static function fromJwtAsPayload(string $jwt, string $publicKey): DemoTokenPayload
    {
        return new DemoTokenPayload(static::baseFromJwtAsPayload($jwt, $publicKey));
    }
}