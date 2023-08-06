<?php

namespace YusamHub\Project0001ClientDemoSdk;

use YusamHub\Project0001ClientDemoSdk\Tokens\JwtDemoTokenHelper;

class ClientDemoSdk extends BaseClientSdk
{
    protected ?int $appId = null;
    protected ?int $userId = null;
    protected ?string $deviceUuid = null;
    protected ?string $publicKeyHash = null;
    protected ?string $privateKey = null;

    /**
     * @return int|null
     */
    public function getAppId(): ?int
    {
        return $this->appId;
    }

    /**
     * @param int|null $appId
     */
    public function setAppId(?int $appId): void
    {
        $this->appId = $appId;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @param int|null $userId
     */
    public function setUserId(?int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string|null
     */
    public function getDeviceUuid(): ?string
    {
        return $this->deviceUuid;
    }

    /**
     * @param string|null $deviceUuid
     */
    public function setDeviceUuid(?string $deviceUuid): void
    {
        $this->deviceUuid = $deviceUuid;
    }

    /**
     * @return string|null
     */
    public function getPublicKeyHash(): ?string
    {
        return $this->publicKeyHash;
    }

    /**
     * @param string|null $publicKeyHash
     */
    public function setPublicKeyHash(?string $publicKeyHash): void
    {
        $this->publicKeyHash = $publicKeyHash;
    }

    /**
     * @return string|null
     */
    public function getPrivateKey(): ?string
    {
        return $this->privateKey;
    }

    /**
     * @param string|null $privateKey
     */
    public function setPrivateKey(?string $privateKey): void
    {
        $this->privateKey = $privateKey;
    }

    protected function generateToken(string $method, array|string $content): string
    {
        return JwtDemoTokenHelper::toJwt(
            $this->appId,
            $this->userId,
            $this->deviceUuid,
            $this->publicKeyHash,
            $this->privateKey
        );
    }

    public function getHome(): ?array
    {
        return $this->doAppRequest(
            $this->api::METHOD_GET,
            '/api/v1',
            get_defined_vars(),
            true
        );
    }
}