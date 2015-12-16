<?php

namespace Skaynetmen\Homework1\Controllers;


use Skaynetmen\Homework1\Core\Auth;
use Skaynetmen\Homework1\Core\Controller;
use Skaynetmen\Homework1\Core\Request;
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
            $view->title = 'Редактирование пользователя - Homework #1';
            $view->user = $userModel->getById($id);
            $view->render();
        } else {
            //show 404
        }
    }

    /**
     * Сохранение работы
     * @param int $id
     */
    public function saveWorkAction($id)
    {
        $request = new Request();

        if ($request->post('name') && !empty($request->post('name'))
            && $request->post('img') && !empty($request->post('img'))
            && $request->post('url') && !empty($request->post('url'))
            && $request->post('desc') && !empty($request->post('desc'))
        ) {
            //на всякий случай почистим поля от html/php тегов
            $data = [
                ':id' => $id,
                ':title' => strip_tags($request->post('name')),
                ':image' => strip_tags($_POST['img']),
                ':link' => strip_tags($request->post('url')),
                ':description' => strip_tags($request->post('desc')),
                ':updated_at' => time()
            ];

            $worksModel = new Works();

            if ($worksModel->save($data)) {
                $json = [
                    'error' => false,
                    'msg' => 'Работа успешно сохранена!'
                ];
            } else {
                $json = [
                    'error' => true,
                    'msg' => 'Не удалось сохранить работу!'
                ];
            }
        } else {
            $json = [
                'error' => true,
                'msg' => 'Заполните все поля!'
            ];
        }

        echo json_encode($json);
    }

    /**
     * Страница добавления пользователя
     * @throws \Exception
     */
    public function newUserAction()
    {
        $view = new View();

        $view->setPartial('partials/admin/add_user.phtml');
        $view->title = 'Добавление пользователя - Homework #1';
        $view->render();
    }

    /**
     * Добавление пользователя
     */
    public function addUserAction()
    {
        $request = new Request();

        if ($request->post('email') && !empty($request->post('email'))
            && filter_var($request->post('email'), FILTER_VALIDATE_EMAIL)
            && $request->post('name') && !empty($request->post('name'))
            && $request->post('lastname') && !empty($request->post('lastname'))
            && $request->post('password') && !empty($request->post('password'))
        ) {
            //на всякий случай почистим поля от html/php тегов
            $data = [
                ':email' => strip_tags($request->post('email')),
                ':name' => strip_tags($request->post('name')),
                ':lastname' => strip_tags($request->post('lastname')),
                ':password' => password_hash(strip_tags($request->post('password')), PASSWORD_BCRYPT),
                ':created_at' => time(),
                ':updated_at' => time()
            ];

            $userModel = new Users();

            if ($userModel->add($data)) {
                $json = [
                    'error' => false,
                    'msg' => 'Пользователь успешно добавлен!'
                ];
            } else {
                $json = [
                    'error' => true,
                    'msg' => 'Не удалось добавить пользователя!'
                ];
            }
        } else {
            $json = [
                'error' => true,
                'msg' => 'Заполните все поля!'
            ];
        }

        echo json_encode($json);
    }

    /**
     * Сохранение пользователя
     * @param int $id
     */
    public function saveUserAction($id)
    {
        $request = new Request();

        if ($request->post('email') && !empty($request->post('email'))
            && filter_var($request->post('email'), FILTER_VALIDATE_EMAIL)
            && $request->post('name') && !empty($request->post('name'))
            && $request->post('lastname') && !empty($request->post('lastname'))
        ) {
            //на всякий случай почистим поля от html/php тегов
            $data = [
                ':id' => (int)$id,
                ':email' => strip_tags($request->post('email')),
                ':name' => strip_tags($request->post('name')),
                ':lastname' => strip_tags($request->post('lastname')),
                ':password' => strip_tags($request->post('password', '')),
                ':updated_at' => time()
            ];

            $userModel = new Users();

            //не мешало бы проверить существование такого пользователя
            if ($userModel->save($data)) {
                $json = [
                    'error' => false,
                    'msg' => 'Пользователь успешно сохранен!'
                ];
            } else {
                $json = [
                    'error' => true,
                    'msg' => 'Не удалось сохранить пользователя!'
                ];
            }
        } else {
            $json = [
                'error' => true,
                'msg' => 'Заполните все поля!'
            ];
        }

        echo json_encode($json);
    }

    public function confirmDeleteWorkAction($id)
    {
        $worksModel = new Works();
        $work = $worksModel->getById($id);

        if ($work) {
            $view = new View();

            $view->setPartial('partials/admin/delete_work.phtml');
            $view->title = 'Удаление работы - Homework #1';
            $view->work = $worksModel->getById($id);
            $view->render();
        } else {
            //show 404
        }
    }

    public function confirmDeleteUserAction($id)
    {
        $userModel = new Users();
        $user = $userModel->getById($id);

        if ($user) {
            $view = new View();

            $view->setPartial('partials/admin/delete_user.phtml');
            $view->title = 'Удаление пользователя - Homework #1';
            $view->user = $userModel->getById($id);
            $view->render();
        } else {
            //show 404
        }
    }

    public function deleteWorkAction($id)
    {
        $worksModel = new Works();

        if ($worksModel->delete($id)) {
            $json = [
                'error' => false,
                'msg' => 'Работа успешно удалена!'
            ];
        } else {
            $json = [
                'error' => true,
                'msg' => 'Не удалось удалить работу!'
            ];
        }

        echo json_encode($json);
    }

    public function deleteUserAction($id)
    {
        $userModel = new Users();

        if ($userModel->delete($id)) {
            $json = [
                'error' => false,
                'msg' => 'Пользователь успешно удален!'
            ];
        } else {
            $json = [
                'error' => true,
                'msg' => 'Не удалось удалить пользователя!'
            ];
        }

        echo json_encode($json);
    }
}