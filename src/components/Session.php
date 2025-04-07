<?php

namespace MolnarSandorBenjamin\RackforestTest\components;

use MolnarSandorBenjamin\RackforestTest\App;
use MolnarSandorBenjamin\RackforestTest\helpers\ArrayHelper;

class Session
{
    public function start(): void
    {
        session_start();
    }

    public function stop(): void
    {
        session_write_close();
    }

    public function get($key, $default = null): mixed
    {
        return ArrayHelper::getValue($_SESSION, $key, $default);
    }

    public function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function clear($key): void
    {
        $this->set($key, null);
    }

    public function setFlash(string $key, $value): void
    {
        $this->set('alert:message', $value);
        $this->set('alert:type', $key == 'error'
            ? 'danger'
            : $key
        );
    }

    public function __destruct()
    {
        $this->stop();
    }
}