<?php

use MolnarSandorBenjamin\RackforestTest\App;
use MolnarSandorBenjamin\RackforestTest\components\Header;
use MolnarSandorBenjamin\RackforestTest\components\PDO;
use MolnarSandorBenjamin\RackforestTest\components\Request;
use MolnarSandorBenjamin\RackforestTest\components\Response;
use MolnarSandorBenjamin\RackforestTest\components\Router;
use MolnarSandorBenjamin\RackforestTest\components\Session;
use MolnarSandorBenjamin\RackforestTest\components\User;
use Smarty\Smarty;

require '../vendor/autoload.php';

$config = require __DIR__ . '/../src/config/config.php';

$app = new App();
App::$app = $app;
$app->setRequest(new Request());
$app->setResponse(new Response());
$app->setHeader(new Header());
$app->setPdo(new PDO($config['mysql']));
$app->setRouter(new Router());
$app->setSession(new Session());
$app->setUser(new User());
$app->setSmarty(new Smarty());
$app->initSmarty();

$controller = $app->getRouter()->getController();
$app->setController($controller);

$action = $app->getRouter()->getAction();
if (method_exists($controller, "beforeAction")) {
    $result = $controller->beforeAction($action);

    if (!$result) {
        $app->getRouter()->setPage('site/not-found');
        $controller = $app->getRouter()->getController();
        $action = $app->getRouter()->getAction();
    }
}

return $controller->$action();
