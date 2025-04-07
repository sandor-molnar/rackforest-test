<?php

namespace MolnarSandorBenjamin\RackforestTest;

use MolnarSandorBenjamin\RackforestTest\components\BaseController;
use MolnarSandorBenjamin\RackforestTest\components\Header;
use MolnarSandorBenjamin\RackforestTest\components\PDO;
use MolnarSandorBenjamin\RackforestTest\components\Request;
use MolnarSandorBenjamin\RackforestTest\components\Response;
use MolnarSandorBenjamin\RackforestTest\components\Router;
use MolnarSandorBenjamin\RackforestTest\components\Session;
use MolnarSandorBenjamin\RackforestTest\components\User;
use Smarty\Smarty;

class App
{
    public static App $app;
    private ?PDO $pdo = null;
    private ?Router $router = null;
    private ?BaseController $controller = null;
    private ?Smarty $smarty = null;
    private ?Session $session = null;
    private ?User $user = null;
    private ?Request $request = null;
    private ?Response $response = null;
    private ?Header $header = null;

    public function initSmarty(): void
    {
        $this->smarty->setTemplateDir(realpath(__DIR__) . '/views');
        $this->smarty->setCompileDir(realpath(__DIR__) . '/views_c');
        $this->smarty->setCacheDir(realpath(__DIR__) . '/runtime/cache');
        $this->smarty->setEscapeHtml(true);

        $this->smarty->assign('loggedIn', $this->user->isLoggedIn());
        if ($this->user->isLoggedIn()) {
            $this->smarty->assign('loggedInUser', $this->user->getUserData());
        }

        if ($this->getSession()->get('alert:message')) {
            $alertMessage = $this->getSession()->get('alert:message');
            $alertType = $this->getSession()->get('alert:type');

            $this->smarty->assign('alertMessage', $alertMessage);
            $this->smarty->assign('alertType', $alertType);

            $this->getSession()->clear('alert:message');
            $this->getSession()->clear('alert:type');
        }
    }

    public function getPdo(): ?PDO
    {
        return $this->pdo;
    }

    public function setPdo(?PDO $pdo): void
    {
        $this->pdo = $pdo;
    }

    public function getRouter(): ?Router
    {
        return $this->router;
    }

    public function setRouter(?Router $router): void
    {
        $this->router = $router;
    }

    public function getController(): BaseController
    {
        return $this->controller;
    }

    public function setController(BaseController $controller): void
    {
        $this->controller = $controller;
    }

    public function getSmarty(): Smarty
    {
        return $this->smarty;
    }

    public function setSmarty(Smarty $smarty): void
    {
        $this->smarty = $smarty;
    }

    public function getSession(): Session
    {
        return $this->session;
    }

    public function setSession(Session $session): void
    {
        if (!is_null($this->session)) {
            $this->session->stop();
        }

        $this->session = $session;
        $this->session->start();
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getRequest(): ?Request
    {
        return $this->request;
    }

    public function setRequest(?Request $request): void
    {
        $this->request = $request;
    }

    public function getResponse(): ?Response
    {
        return $this->response;
    }

    public function setResponse(?Response $response): void
    {
        $this->response = $response;
    }

    public function getHeader(): ?Header
    {
        return $this->header;
    }

    public function setHeader(?Header $header): void
    {
        $this->header = $header;
    }
}