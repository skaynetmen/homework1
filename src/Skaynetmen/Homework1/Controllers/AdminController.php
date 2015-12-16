<?php

namespace Skaynetmen\Homework1\Controllers;


use Skaynetmen\Homework1\Core\Auth;
use Skaynetmen\Homework1\Core\Controller;
use Skaynetmen\Homework1\Core\View;
use Skaynetmen\Homework1\Models\Users;
use Skaynetmen\Homework1\Models\Works;

class AdminController extends Controller
{
    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        if (!Auth::loggedIn()) {
            $this->redirect('/auth');
        }
    }

    /**
     * Страница со списком работ и пользователей
     * @throws \Exception
     */
    public function indexAction()
    {
        $view = new View();
        $worksModel = new Works();
        $usersModel = new Users();

        $view->setPartial('partials/admin/admin.phtml');
        $view->title = 'Admin - Homework #1';
        $view->works = $worksModel->get();
        $view->users = $usersModel->get();
        $view->render();
    }

    /**
     * Страница редактирования работы
     * @param int $id
     * @throws \Exception
     */
    public function editWorkAction($id)
    {
        $worksModel = new Works();
        $work = $worksModel->getById($id);

        if ($work) {
            $view = new View();

            $view->setPartial('partials/admin/edit_work.phtml');
            $view->title = 'Редактирование работы - Homework #1';
            $view->work = $worksModel->getById($id);
            $view->render();
        } else {
            //show 404
        }
    }

    /**
     * Страница редактирования пользователя
     * @param int $id
     * @throws \Exception
     */
    public function editUserAction($id)
    {
        $userModel = new Users();
        $user = $userModel->getById($id);

        if ($user) {
            $view = new View();

            $view->setPartial('partials/admin/edit_user.phtml');
            $view->title = 'Редактирование работы - Homework #1';
            $view->user = $userModel->getById($id);
            $view->render();
        } else {
            //show 404
        }
    }
}