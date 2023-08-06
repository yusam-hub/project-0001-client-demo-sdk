<?php

namespace YusamHub\Project0001ClientDemoSdk\Heads;

class BaseTokenHead
{
    public ?string $typ = null;
    public ?string $alg = null;

    public function __construct(array $properties = [])
    {
        foreach ($properties as $k => $v) {
            if (property_exists($this, $k)) {
                $this->{$k} = $v;
            }
        }
    }
}