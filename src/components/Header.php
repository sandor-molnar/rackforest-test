<?php

namespace MolnarSandorBenjamin\RackforestTest\components;

class Header
{
    public function set($key, $value): void
    {
        header($key . ': ' . $value);
    }
}