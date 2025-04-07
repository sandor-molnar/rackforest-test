<?php

namespace MolnarSandorBenjamin\RackforestTest\controllers;

use MolnarSandorBenjamin\RackforestTest\App;
use MolnarSandorBenjamin\RackforestTest\components\BaseController;
use MolnarSandorBenjamin\RackforestTest\helpers\ArrayHelper;

class SiteController extends BaseController
{
    public array $publicPages = ['index', 'login', 'notFound', 'logout', 'post'];

    public function index()
    {
        $db = App::$app->getPdo();
        $statement = $db->prepare("
            SELECT
                p.*,
                u.email as author_email
            FROM 
                `posts` p
            LEFT JOIN `users` u ON u.id = p.user_id
            WHERE
                p.`publish_at` IS NOT NULL
            ORDER BY p.`id` DESC
        ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($result as &$post) {
            $post['short_content'] = substr($post['content'], 0, 100);
        }

        $this->render('site/index.tpl', [
            'posts' => $result,
        ]);
    }

    public function post()
    {
        $id = ArrayHelper::getValue(
            App::$app->getRequest()->get(),
            'id'
        );

        if (!$id) {
            App::$app->getSession()->setFlash('error', 'A poszt nem található.');
            App::$app->getResponse()->redirect('posts/index');
        }

        $db = App::$app->getPdo();
        $statement = $db->prepare("
             SELECT
                p.*,
                u.email as author_email
            FROM 
                `posts` p
            LEFT JOIN `users` u ON u.id = p.user_id
            WHERE
                p.`publish_at` IS NOT NULL
                AND p.id = :id
        ");
        $statement->execute([
            'id' => $id,
        ]);
        $result = $statement->fetch();

        if (!$result) {
            App::$app->getSession()->setFlash('error', 'A poszt nem található.');
            App::$app->getResponse()->redirect('posts/index');
        }

        $this->render('site/post.tpl', [
            'post' => $result,
        ]);
    }

    public function login()
    {
        if (App::$app->getRequest()->isPost()) {
            $email = ArrayHelper::getValue($_POST, 'email');
            $password = ArrayHelper::getValue($_POST, 'password');

            if ($email && $password) {
                $db = App::$app->getPdo();

                $statement = $db->prepare("
                    SELECT
                        `email`,
                        `id`,
                        `is_active`,
                        `password`
                    FROM
                        `users`
                    WHERE
                        `email` = :email
                        AND `is_active` = 1
                ");
                $statement->execute([
                    'email' => $email,
                ]);
                $user = $statement->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    App::$app->getUser()->login($user['id']);
                    App::$app->getSession()->setFlash('success', 'Sikeres bejelentkezés.');
                    App::$app->getResponse()->redirect('site/index');
                } else {
                    App::$app->getSession()->setFlash('error', 'Hibás email cím vagy jelszó.');
                    App::$app->getResponse()->redirect('site/login');
                }
            }
        }

        $this->render('site/login.tpl');
    }

    public function logout()
    {
        App::$app->getUser()->logout();
        App::$app->getSession()->setFlash('success', 'Sikeres kijelentkezés.');
        App::$app->getResponse()->redirect('site/index');
    }

    public function notFound()
    {
        $this->render('site/not-found.tpl');
    }
}