<?php

namespace MolnarSandorBenjamin\RackforestTest\controllers;

use MolnarSandorBenjamin\RackforestTest\App;
use MolnarSandorBenjamin\RackforestTest\components\BaseController;
use MolnarSandorBenjamin\RackforestTest\helpers\ArrayHelper;

class PostsController extends BaseController
{
    public function index()
    {
        $db = App::$app->getPdo();
        $statement = $db->prepare("
            SELECT
                * 
            FROM 
                `posts`
            ORDER BY id ASC
        ");
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $this->render('posts/index.tpl', [
            'posts' => $result,
        ]);
    }

    public function create()
    {
        if (App::$app->getRequest()->isPost()) {
            $db = App::$app->getPdo();

            $title = $_POST['title'];
            $content = $_POST['content'];

            $statement = $db->prepare("
                INSERT INTO `posts` (`title`, `content`, `user_id`, `created_at`, `update_at`) VALUES (:title, :content, :user_id, NOW(), NOW())
            ");
            $result = $statement->execute([
                'title' => $title,
                'content' => $content,
                'user_id' => App::$app->getUser()->getId(),
            ]);

            if ($result) {
                App::$app->getSession()->setFlash('success', 'Poszt létrehozva.');
                App::$app->getResponse()->redirect('posts/view&id=' . $db->lastInsertId());
            } else {
                App::$app->getSession()->setFlash('error', 'Poszt létrehozása sikertelen.');
                App::$app->getResponse()->redirect('posts/create');
            }
        }

        $this->render('posts/form.tpl', [
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

            $title = $_POST['title'];
            $content = $_POST['content'];

            $statement = $db->prepare("
                UPDATE 
                    `posts`
                SET
                    `title` = :title,
                    `content` = :content,
                    `update_at` = NOW()
                WHERE
                    `id` = :id
            ");
            $result = $statement->execute([
                'title' => $title,
                'content' => $content,
                'id' => $id,
            ]);

            if ($result) {
                App::$app->getSession()->setFlash('success', 'Poszt módosítva.');
                App::$app->getResponse()->redirect('posts/view&id=' . $id);
            } else {
                App::$app->getSession()->setFlash('error', 'Poszt módosítása sikertelen.');
                App::$app->getResponse()->redirect('posts/update&id=' . $id);
            }
        } else {
            $db = App::$app->getPdo();
            $statement = $db->prepare("
            SELECT
                * 
            FROM 
                `posts`
            WHERE
                id = :id
        ");
            $statement->execute([
                'id' => $id,
            ]);
            $result = $statement->fetch();

            $this->render('posts/form.tpl', [
                'scenario' => 'update',
                'post' => $result,
            ]);
        }
    }

    public function view()
    {
        $id = ArrayHelper::getValue(
            App::$app->getRequest()->get(),
            'id'
        );

        $result = $this->validateId($id);

        $this->render('posts/view.tpl', [
            'post' => $result,
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
                `posts`
            WHERE
                id = :id
        ");
        $statement->execute([
            'id' => $id,
        ]);

        App::$app->getSession()->setFlash('success', 'A poszt törölve.');
        App::$app->getResponse()->redirect('posts/index');
    }

    public function publish()
    {
        $id = ArrayHelper::getValue(
            App::$app->getRequest()->get(),
            'id'
        );

        $post = $this->validateId($id);

        if (!is_null($post['publish_at']))   {
            App::$app->getSession()->setFlash('error', 'A poszt már publikálva van.');
            App::$app->getResponse()->redirect('posts/view&id=' . $id);
        }

        $db = App::$app->getPdo();
        $statement = $db->prepare("
            UPDATE 
                `posts`
            SET
                `publish_at` = NOW(),
                `update_at` = NOW()
            WHERE
                id = :id
        ");
        $statement->execute([
            'id' => $id,
        ]);

        App::$app->getSession()->setFlash('success', 'A poszt publikálva.');
        App::$app->getResponse()->redirect('posts/view&id=' . $id);
    }

    private function validateId($id)
    {
        if (!$id) {
            App::$app->getSession()->setFlash('error', 'A poszt nem található.');
            App::$app->getResponse()->redirect('posts/index');
        }

        $db = App::$app->getPdo();
        $statement = $db->prepare("
            SELECT 
                *
            FROM
                `posts`
            WHERE
                id = :id
        ");
        $statement->execute([
            'id' => $id,
        ]);
        $result = $statement->fetch();

        if (!$result) {
            App::$app->getSession()->setFlash('error', 'A poszt nem található.');
            App::$app->getResponse()->redirect('posts/index');
        }

        return $result;
    }
}