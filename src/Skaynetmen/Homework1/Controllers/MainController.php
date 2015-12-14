<?php

namespace Skaynetmen\Homework1\Controllers;

use Skaynetmen\Homework1\Core\Auth;
use Skaynetmen\Homework1\Core\Controller;
use Skaynetmen\Homework1\Core\View;
use Skaynetmen\Homework1\Models\Feedback;
use Skaynetmen\Homework1\Models\Works;

class MainController extends Controller
{
    public function indexAction()
    {
        $view = new View();
        $view->setPartial('partials/index.phtml');
        $view->title = 'Homework #1';
        $view->render();
    }

    public function worksAction()
    {
        $worksModel = new Works();

        $view = new View();
        $view->setPartial('partials/works.phtml');
        $view->title = 'Мои работы - Homework #1';
        $view->works = $worksModel->get();
        $view->render();
    }

    //POST
    public function addWorkAction()
    {
        if (isset($_POST['name']) && isset($_FILES['img']) && isset($_POST['url']) && isset($_POST['desc'])) {
            $data = [
                ':title' => $_POST['name'],
                ':img' => $_POST['img'],
                ':url' => $_POST['url'],
                ':desc' => $_POST['desc']
            ];

            $worksModel = new Works();

            if ($worksModel->add($data)) {
                $json = [
                    'error' => false,
                    'msg' => 'Работа успешно добавлена!'
                ];
            } else {
                $json = [
                    'error' => true,
                    'msg' => 'Не удалось добавить работу!'
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

    public function feedbackAction()
    {
        $view = new View();
        $view->setPartial('partials/feedback.phtml');
        $view->title = 'Обратная связь - Homework #1';
        $view->render();
    }

    //POST
    public function sendFeedbackAction()
    {
        if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
            $feedbackModel = new Feedback();

            $msg = $feedbackModel->msg($_POST['name'], $_POST['email'], $_POST['message']);

            if ($feedbackModel->send($msg)) {
                $json = [
                    'error' => false,
                    'msg' => 'Сообщение успешно успешно отправлено!'
                ];
            } else {
                $json = [
                    'error' => true,
                    'msg' => 'Не удалось отправить сообщение!'
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

    public function authAction()
    {
        if (!Auth::loggedIn()) {
            $view = new View();
            $view->setTemplate('auth.phtml');
            $view->setPartial('partials/auth.phtml');
            $view->title = 'Авторизация - Homework #1';
            $view->render();
        } else {
            $this->redirect('/');
        }
    }

    //POST

    private function redirect($url, $permanent = false)
    {
        header('Location: ' . $url, true, $permanent ? 301 : 302);
        exit();
    }

    public function loginAction()
    {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $authModel = new \Skaynetmen\Homework1\Models\Auth();

            $result = $authModel->get($_POST['email']);

            if ($result && password_verify($_POST['password'], $result->password)) {
                if (Auth::login($_POST['email'])) {
                    $json = [
                        'error' => false,
                        'msg' => 'Авторизация прошла успешно!'
                    ];
                } else {
                    $json = [
                        'error' => true,
                        'msg' => 'Не удалось авторизоваться, попробуйте еще раз позднее'
                    ];
                }
            } else {
                $json = [
                    'error' => true,
                    'msg' => 'Неверный логин или пароль!'
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

    public function logoutAction()
    {
        if (Auth::logout()) {
            $this->redirect('/');
        } else {
            throw new \Exception('Не удается завершить сессию.');
        }
    }
}