<?php

namespace YusamHub\Project0001ClientDemoSdk;

use YusamHub\Project0001ClientDemoSdk\Tokens\JwtDemoTokenHelper;

class ClientDemoSdk extends BaseClientSdk
{
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