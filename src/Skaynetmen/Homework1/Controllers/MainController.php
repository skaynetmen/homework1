<?php

namespace Skaynetmen\Homework1\Controllers;

use Skaynetmen\Homework1\Core\Auth;
use Skaynetmen\Homework1\Core\Controller;
use Skaynetmen\Homework1\Core\Request;
use Skaynetmen\Homework1\Core\View;
use Skaynetmen\Homework1\Models\Feedback;
use Skaynetmen\Homework1\Models\Recapthca;
use Skaynetmen\Homework1\Models\Works;
use Websafe\Blueimp\JqueryFileUploadHandler;

class MainController extends Controller
{
    /**
     * Главная страница
     * @throws \Exception
     */
    public function indexAction()
    {
        $view = new View();

        $view->setPartial('partials/index.phtml');
        $view->title = 'Homework #1';
        $view->render();
    }

    /**
     * Страница мои работы
     * @throws \Exception
     */
    public function worksAction()
    {
        $worksModel = new Works();

        $view = new View();

        $view->setPartial('partials/works.phtml');
        $view->title = 'Мои работы - Homework #1';
        $view->works = $worksModel->get();
        $view->render();
    }

    /**
     * Добавление новой работы
     */
    public function addWorkAction()
    {
        $request = new Request();

        if ($request->post('name') && !empty($request->post('name'))
            && $request->post('img') && !empty($request->post('img'))
            && $request->post('url') && !empty($request->post('url'))
            && $request->post('desc') && !empty($request->post('desc'))
        ) {
            $data = [
                ':title' => strip_tags($request->post('name')),
                ':image' => $_POST['img'],
                ':link' => strip_tags($request->post('url')),
                ':description' => strip_tags($request->post('desc'))
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

    /**
     * Страница обратной связи
     * @throws \Exception
     */
    public function feedbackAction()
    {
        $view = new View();

        $view->setPartial('partials/feedback.phtml');
        $view->title = 'Обратная связь - Homework #1';
        $view->render();
    }

    /**
     * Отправка сообщения
     * @throws \Exception
     */
    public function sendFeedbackAction()
    {
        $request = new Request();
        $recaptchaModel = new Recapthca();

        if ($request->post('g-recaptcha-response') && $recaptchaModel->check($request->post('g-recaptcha-response'))) {
            if ($request->post('name') && !empty($request->post('name'))
                && $request->post('email') && !empty($request->post('email'))
                && filter_var($request->post('email'), FILTER_VALIDATE_EMAIL)
                && $request->post('message') && !empty($request->post('message'))
            ) {
                $feedbackModel = new Feedback();

                $msg = $feedbackModel->msg($request->post('name'), $request->post('email'), $request->post('message'));

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
                    'msg' => 'Проверьте заполнены ли все поля и правильно ли указан email!'
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

    /**
     * Страница авторизации
     * @throws \Exception
     */
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

    /**
     * Авторизация пользователя
     */
    public function loginAction()
    {
        $request = new Request();

        if ($request->post('email') && !empty($request->post('email'))
            && filter_var($request->post('email'), FILTER_VALIDATE_EMAIL)
            && $request->post('password') && !empty($request->post('password'))
        ) {
            $authModel = new \Skaynetmen\Homework1\Models\Auth();

            $result = $authModel->get($request->post('email'));

            if ($result && password_verify($request->post('password'), $result->password)) {
                if (Auth::login($request->post('email'))) {
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

    /**
     * Загрузка файла
     */
    public function uploadAction()
    {
        $config = [
            'script_url' => './works/upload',
            'upload_dir' => BASEPATH . 'app/uploads/',
            'upload_url' => './uploads/',
            'delete_type' => 'POST'
        ];

        new JqueryFileUploadHandler($config);
    }

    /**
     * Страница выхода из системы
     * @throws \Exception
     */
    public function logoutAction()
    {
        if (Auth::logout()) {
            $this->redirect('/');
        } else {
            throw new \Exception('Не удается завершить сессию.');
        }
    }
}