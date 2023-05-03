<?php
namespace App\Controller;

use App\Model\EntityModel;
use App\Model\CommentModel;
use App\Helper\AuthHelper;
use Exception;

class EntityController extends BaseController
{
    private $entityModel;
    private $commentModel;

    public function __construct()
    {
        parent::__construct();
        $this->entityModel = new EntityModel();
        $this->commentModel = new CommentModel();
    }

    public function index()
    {
        $entities = $this->entityModel->getAllEntities();
        $this->view->render('entity/index', ['entities' => $entities]);
    }

    public function show($id)
    {
        $entity = $this->entityModel->getEntityById($id);

        if (!$entity) {
            $this->view->render('error/404');
            return;
        }

        $comments = $this->commentModel->getCommentsByEntityId($entity['id']);
        $this->view->render('entity/show', ['entity' => $entity, 'comments' => $comments]);
    }

    public function create()
    {
        AuthHelper::requireLoggedIn();

        $this->view->render('entity/create');
    }

    public function store()
    {
        AuthHelper::requireLoggedIn();

        $title = $_POST['title'];
        $content = $_POST['content'];
        $userId = $_SESSION['user_id'];

        try {
            $this->entityModel->createEntity($title, $content, $userId);
            header('Location: /entity');
            exit;
        } catch (Exception $e) {
            $this->view->render('entity/create', ['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        AuthHelper::requireLoggedIn();

        $entity = $this->entityModel->getEntityById($id);

        if (!$entity) {
            $this->view->render('error/404');
            return;
        }

        $this->view->render('entity/edit', ['entity' => $entity]);
    }

    public function update($id)
    {
        AuthHelper::requireLoggedIn();

        $title = $_POST['title'];
        $content = $_POST['content'];

        try {
            $this->entityModel->updateEntity($id, $title, $content);
            header('Location: /entity');
            exit;
        } catch (Exception $e) {
            $entity = ['id' => $id, 'title' => $title, 'content' => $content];
            $this->view->render('entity/edit', ['entity' => $entity, 'error' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        AuthHelper::requireLoggedIn();

        try {
            $this->entityModel->deleteEntity($id);
            header('Location: /entity');
            exit;
        } catch (Exception $e) {
            $this->view->render('error/500', ['error' => $e->getMessage()]);
        }
    }

    public function deleteComment($id)
    {
        AuthHelper::requireLoggedIn();

        try {
            $comment = $this->commentModel->getCommentById($id);
            $this->commentModel->deleteComment($id);
            header("Location: /entity/{$comment['entity_id']}");
            exit;
        } catch (Exception $e) {
            $this->view->render('error/500', ['error' => $e->getMessage()]);
        }
    }
}