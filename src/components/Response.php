<?php


namespace MolnarSandorBenjamin\RackforestTest\components;

use JetBrains\PhpStorm\NoReturn;
use MolnarSandorBenjamin\RackforestTest\App;

class Response
{
    #[NoReturn] public function redirect($location): void
    {
        App::$app->getHeader()->set('Location', 'index.php?page=' . $location);
        die();
    }
}