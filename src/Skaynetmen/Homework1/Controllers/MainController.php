<?php

namespace Skaynetmen\Homework1\Controllers;

use Skaynetmen\Homework1\Core\Auth;
use Skaynetmen\Homework1\Core\Controller;
use Skaynetmen\Homework1\Core\View;
use Skaynetmen\Homework1\Models\Feedback;
use Skaynetmen\Homework1\Models\Recapthca;
use Skaynetmen\Homework1\Models\Works;
use Websafe\Blueimp\JqueryFileUploadHandler;

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
        if (isset($_POST['name']) && isset($_POST['img']) && isset($_POST['url']) && isset($_POST['desc'])) {
            $data = [
                ':title' => $_POST['name'],
                ':image' => $_POST['img'],
                ':link' => $_POST['url'],
                ':description' => $_POST['desc']
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
        $recaptchaModel = new Recapthca();

        if (isset($_POST['g-recaptcha-response']) && $recaptchaModel->check($_POST['g-recaptcha-response'])) {
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
        } else {
            $json = [
                'error' => true,
                'msg' => 'Google reCapthca сказала что вы робот!'
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

    public function uploadAction()
    {
        $config = [
            'script_url' => /*$this->getFullUrl() . */
                './works/upload',
            'upload_dir' => BASEPATH . 'app/uploads/',
            'upload_url' => /*$this->getFullUrl() . */
                './uploads/',
            'delete_type' => 'POST'
        ];

        new JqueryFileUploadHandler($config);
    }

    private function getFullUrl()
    {
        $https = !empty($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'], 'on') === 0 ||
            !empty($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            strcasecmp($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') === 0;

        return
            ($https ? 'https://' : 'http://') .
            (!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'] . '@' : '') .
            (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'] .
                ($https && $_SERVER['SERVER_PORT'] === 443 ||
                $_SERVER['SERVER_PORT'] === 80 ? '' : ':' . $_SERVER['SERVER_PORT']))) .
            substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
    }
}