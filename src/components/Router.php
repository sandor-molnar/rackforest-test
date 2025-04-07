<?php


namespace MolnarSandorBenjamin\RackforestTest\components;

use MolnarSandorBenjamin\RackforestTest\controllers\SiteController;
use MolnarSandorBenjamin\RackforestTest\helpers\StringHelper;

class Router
{
    private array $args;
    private string $controllerName;
    private BaseController $controller;
    private string $action;

    public function __construct()
    {
        if (!isset($_GET['page'])) {
            $_GET['page'] = 'site/index';
        }

        $this->setPage($_GET['page']);
        unset($_GET['page']);

        $this->args = $_GET;
    }

    public function setPage($page): void
    {
        [$controller, $action] = explode('/', $page);
        if (!isset($controller) || !isset($action)) {
            $controller = 'site';
            $action = 'not-found';
        }

        $this->controllerName = ucfirst(StringHelper::kebabToCamel($controller)) . "Controller";
        $this->action = StringHelper::kebabToCamel($action);

        $controllerClassName = "MolnarSandorBenjamin\RackforestTest\controllers\\$this->controllerName";
        if (!class_exists($controllerClassName) || !method_exists($controllerClassName, $this->action)) {
            $controllerClassName = "MolnarSandorBenjamin\RackforestTest\controllers\SiteController";
            $this->action = "notFound";
        }
        $this->controller = new $controllerClassName();
    }

    public function getArgs(): array
    {
        return $this->args;
    }

    public function getController(): BaseController
    {
        return $this->controller;
    }

    public function getAction(): string
    {
        return $this->action;
    }
}