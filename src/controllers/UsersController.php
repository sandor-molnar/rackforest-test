<?php

namespace MolnarSandorBenjamin\RackforestTest\controllers;

use MolnarSandorBenjamin\RackforestTest\App;
use MolnarSandorBenjamin\RackforestTest\components\BaseController;
use MolnarSandorBenjamin\RackforestTest\helpers\ArrayHelper;

class UsersController extends BaseController
{
    public function index()
    {
        $db = App::$app->getPdo();
        $statement = $db->prepare("
            SELECT
                * 
            FROM 
                `users`
            ORDER BY id ASC
        ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $this->render('users/index.tpl', [
            'users' => $result,
        ]);
    }

    public function create()
    {
        if (App::$app->getRequest()->isPost()) {
            $db = App::$app->getPdo();

            $email = $_POST['email'];
            $password = $_POST['password'];
            $isActive = isset($_POST['is_active']) ? 1 : 0;

            $statement = $db->prepare("
                INSERT INTO `users` (email, password, is_active) VALUES (:email, :password, :is_active)
            ");
            $result = $statement->execute([
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'is_active' => $isActive,
            ]);

            if ($result) {
                App::$app->getSession()->setFlash('success', 'Felhasználó létrehozva.');
                App::$app->getResponse()->redirect('users/view&id=' . $db->lastInsertId());
            } else {
                App::$app->getSession()->setFlash('error', 'Felhasználó létrehozása sikertelen.');
                App::$app->getResponse()->redirect('users/create');
            }
        }

        $this->render('users/form.tpl', [
            'scenario' => 'create',
        ]);
    }

    public function update()
    {
        $id = ArrayHelper::getValue(
            App::$app->getRequest()->get(),
            'id'
        );

        $this->validateId($id);

        if (App::$app->getRequest()->isPost()) {
            $db = App::$app->getPdo();

            $email = $_POST['email'];
            $password = $_POST['password'];
            $isActive = isset($_POST['is_active']) ? 1 : 0;

            $statement = $db->prepare("
                UPDATE 
                    `users`
                SET 
                    `email` = :email, 
                    " . (!empty($password) ? '`password` = :password,' : '') . "
                    `is_active` = :is_active
                WHERE
                    `id` = :id
            ");
            $params = [
                'email' => $email,
                'is_active' => $isActive,
                'id' => $id,
            ];
            if (!empty($password)) {
                $params['password'] = password_hash($password, PASSWORD_DEFAULT);
            }
            $result = $statement->execute($params);

            if ($result) {
                App::$app->getSession()->setFlash('success', 'Felhasználó módosítva.');
                App::$app->getResponse()->redirect('users/view&id=' . $id);
            } else {
                App::$app->getSession()->setFlash('error', 'Felhasználó módosítása sikertelen.');
                App::$app->getResponse()->redirect('users/update&id=' . $id);
            }
        } else {
            $db = App::$app->getPdo();
            $statement = $db->prepare("
            SELECT
                * 
            FROM 
                `users`
            WHERE
                id = :id
        ");
            $statement->execute([
                'id' => $id,
            ]);
            $result = $statement->fetch();

            $this->render('users/form.tpl', [
                'scenario' => 'update',
                'user' => $result,
            ]);
        }
    }

    public function view()
    {
        $id = ArrayHelper::getValue(
            App::$app->getRequest()->get(),
            'id'
        );

        $this->validateId($id);

        $db = App::$app->getPdo();
        $statement = $db->prepare("
            SELECT
                * 
            FROM 
                `users`
            WHERE
                id = :id
        ");
        $statement->execute([
            'id' => $id,
        ]);
        $result = $statement->fetch();

        if (!$result) {
            App::$app->getSession()->setFlash('error', 'A felhasználó nem található.');
            App::$app->getResponse()->redirect('users/index');
        }

        $this->render('users/view.tpl', [
            'user' => $result,
        ]);
    }

    public function delete()
    {
        $id = ArrayHelper::getValue(
            App::$app->getRequest()->get(),
            'id'
        );

        $this->validateId($id);

        $db = App::$app->getPdo();
        $statement = $db->prepare("
            DELETE FROM 
                `users`
            WHERE
                id = :id
        ");
        $statement->execute([
            'id' => $id,
        ]);

        App::$app->getSession()->setFlash('success', 'A felhasználó törölve.');
        App::$app->getResponse()->redirect('users/index');
    }


    private function validateId($id)
    {
        if (!$id) {
            App::$app->getSession()->setFlash('error', 'A felhasználó nem található.');
            App::$app->getResponse()->redirect('users/index');
        }

        $db = App::$app->getPdo();
        $statement = $db->prepare("
            SELECT 
                *
            FROM
                `users`
            WHERE
                id = :id
        ");
        $statement->execute([
            'id' => $id,
        ]);
        $result = $statement->fetch();

        if (!$result) {
            App::$app->getSession()->setFlash('error', 'A felhasználó nem található.');
            App::$app->getResponse()->redirect('users/index');
        }

        return $result;
    }
}