<?php

namespace YusamHub\Project0001ClientDemoSdk;

use YusamHub\CurlExt\CurlExtDebug;

abstract class BaseClientSdk
{
    const TOKEN_KEY_NAME = 'X-Token';
    protected CurlExtDebug $api;
    protected bool $isDebugging;
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
     * @param string $method
     * @param array|string $content
     * @return string
     */
    abstract protected function generateToken(string $method, array|string $content): string;

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
            $headers[self::TOKEN_KEY_NAME] = $this->generateToken($requestMethod, $requestParams);
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