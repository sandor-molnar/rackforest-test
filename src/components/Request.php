<?php

namespace MolnarSandorBenjamin\RackforestTest\components;

class Request
{
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function isPost(): bool
    {
        return $this->method() === 'POST';
    }

    public function isGet(): bool
    {
        return $this->method() === 'GET';
    }


    public function get(): array
    {
        return $_GET;
    }

    public function post(): array
    {
        return $_POST;
    }
}