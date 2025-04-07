<?php

namespace MolnarSandorBenjamin\RackforestTest\components;

use MolnarSandorBenjamin\RackforestTest\App;

class User
{
    private bool $loggedIn = false;
    private ?string $userId = null;

    private ?array $userData = null;

    public function __construct()
    {
        $session = App::$app->getSession();
        $this->userId = $session->get('userid');

        if ($this->userId) {
            $this->loadUserData();

            if ($this->userData) {
                $this->loggedIn = true;
            }
        }
    }

    public function getUserData()
    {
        if ($this->userData) {
            return $this->userData;
        }

        $this->loadUserData();

        return $this->userData;
    }

    private function loadUserData(): void
    {
        $pdo = App::$app->getPdo();
        $statement = $pdo->prepare("
            SELECT
                *
            FROM
                `users`
            WHERE
                id = :userid
                AND is_active = 1
        ");
        $statement->execute([
            ':userid' => $this->userId,
        ]);
        $result = $statement->fetch();

        if ($result) {
            $this->userData = $result;
        }
    }

    public function login($id): void
    {
        $session = App::$app->getSession();
        $session->set('userid', $id);
    }

    public function logout(): bool
    {
        if (!$this->isLoggedIn()) {
            return true;
        }

        $session = App::$app->getSession();
        $session->clear('userid');

        return true;
    }

    public function isLoggedIn(): bool
    {
        return $this->loggedIn;
    }

    public function getId(): string
    {
        return $this->userId;
    }
}