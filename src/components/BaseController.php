<?php

namespace MolnarSandorBenjamin\RackforestTest\components;

use MolnarSandorBenjamin\RackforestTest\App;
use Smarty\Smarty;

class BaseController
{
    public array $publicPages = [];

    public function beforeAction(string $action): bool
    {
        $user = App::$app->getUser();

        if (!in_array($action, $this->publicPages) && !$user->isLoggedIn()) {
            return false;
        }

        return true;
    }

    public function render($view, array $params = []): void
    {
        foreach ($params as $key => $value) {
            App::$app->getSmarty()->assign($key, $value);
        }

        App::$app->getSmarty()->display($view);
    }
}