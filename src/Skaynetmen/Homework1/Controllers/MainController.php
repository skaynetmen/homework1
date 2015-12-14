<?php

namespace Skaynetmen\Homework1\Controllers;

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
        $view = new View();
        $view->setTemplate('auth.phtml');
        $view->setPartial('partials/auth.phtml');
        $view->title = 'Авторизация - Homework #1';
        $view->render();
    }

    //POST
    public function loginAction()
    {

    }

    public function logoutAction()
    {

    }
}