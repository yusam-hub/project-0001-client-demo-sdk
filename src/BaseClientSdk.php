<?php

namespace YusamHub\Project0001ClientDemoSdk;

use YusamHub\CurlExt\CurlExtDebug;
use YusamHub\Project0001ClientDemoSdk\Tokens\JwtDemoTokenHelper;

abstract class BaseClientSdk
{
    const TOKEN_KEY_NAME = 'X-Token';
    protected CurlExtDebug $api;
    protected bool $isDebugging;
    protected ?int $appId = null;
    protected ?int $userId = null;
    protected ?string $deviceUuid = null;
    protected ?string $publicKeyHash = null;
    protected ?string $privateKey = null;
    public function __construct(array $config = [])
    {
        if (!isset($config['baseUrl'])) {
            throw new \RuntimeException("baseUrl not exists in config");
        }
        if (!isset($config['isDebugging'])) {
            throw new \RuntimeException("isDebugging not exists in config");
        }
        if (!isset($config['storageLogFile'])) {
            throw new \RuntimeException("storageLogFile not exists in config");
        }
        if (!isset($config['appId'])) {
            throw new \RuntimeException("appId not exists in config");
        }
        if (!isset($config['userId'])) {
            throw new \RuntimeException("userId not exists in config");
        }
        if (!isset($config['deviceUuid'])) {
            throw new \RuntimeException("deviceUuid not exists in config");
        }
        if (!isset($config['publicKeyHash'])) {
            throw new \RuntimeException("publicKeyHash not exists in config");
        }
        if (!isset($config['privateKey'])) {
            throw new \RuntimeException("privateKey not exists in config");
        }
        foreach($config as $k => $v) {
            if (property_exists($this, $k)) {
                $this->{$k} = $v;
            }
        }
        $this->api = new CurlExtDebug($config['baseUrl'], $config['storageLogFile']);
        $this->api->isDebugging = $this->isDebugging();
    }

    public function getApi(): CurlExtDebug
    {
        return $this->api;
    }

    public function isDebugging(): bool
    {
        return $this->isDebugging;
    }

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

    protected function generateToken(): string
    {
        return JwtDemoTokenHelper::toJwt(
            $this->appId,
            $this->userId,
            $this->deviceUuid,
            $this->publicKeyHash,
            $this->privateKey
        );
    }

    /**
     * @param string $requestMethod
     * @param string $requestUri
     * @param array $requestParams
     * @param bool $authorize
     * @return array|null
     */
    protected function doAppRequest(
        string $requestMethod,
        string $requestUri,
        array $requestParams,
        bool $authorize = false,
    ): ?array
    {
        $headers = [
            'Accept' => $this->api::CONTENT_TYPE_APPLICATION_JSON
        ];

        if ($authorize) {
            $headers[self::TOKEN_KEY_NAME] = $this->generateToken();
        }

        if ($requestMethod !== $this->api::METHOD_GET) {
            $headers[$this->api::HEADER_CONTENT_TYPE] = $this->api::CONTENT_TYPE_APPLICATION_JSON;
        }

        $response = $this->api->request($requestMethod, $requestUri, $requestParams, $headers);

        if ($response->isStatusCode(200) && $response->isContentTypeJson()) {
            return $response->toArray();
        }

        return null;
    }
}