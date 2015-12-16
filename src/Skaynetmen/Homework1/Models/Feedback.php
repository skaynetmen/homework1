<?php

namespace Skaynetmen\Homework1\Models;

use Skaynetmen\Homework1\Core\Model;

class Feedback extends Model
{
    /**
     * Формирует сообщение
     * @param $name
     * @param $email
     * @param $message
     * @return string
     */
    public function msg($name, $email, $message)
    {
        //на всякий случай почистим поля от html/php тегов
        $name = strip_tags($name);
        $email = strip_tags($email);
        $message = strip_tags($message);

        $text = "<h3>{$name}</h3>";
        $text .= "<h4>{$email}</h4>";
        $text .= "<p>{$message}</p>";

        return $text;
    }

    /**
     * Отправка письма
     * @param $msg
     * @return bool
     * @throws \Exception
     * @throws \phpmailerException
     */
    public function send($msg)
    {
        $config = $this->getConfig();

        if ($config) {
            $mail = new \PHPMailer();

            $mail->isSMTP();
            $mail->Host = $config['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $config['username'];
            $mail->Password = $config['password'];
            $mail->SMTPSecure = $config['secure'];
            $mail->Port = 465;

            $mail->setFrom($config['username'], $config['siteName']);
            $mail->addAddress($config['to']);

            $mail->isHTML(true);

            $mail->Subject = $config['subject'];
            $mail->Body = $msg;
            $mail->AltBody = strip_tags($msg);

            $result = $mail->send();

            if (!$result && ENVIRONMENT == 'dev') {
                throw new \Exception($mail->ErrorInfo);
            }

            return $result;
        }

        return false;
    }

    /**
     * Возвращает настройки smtp из файла
     * @return array|bool
     * @throws \Exception
     */
    private function getConfig()
    {
        $file = BASEPATH . 'config/smtp.ini';

        if (file_exists($file)) {
            $ini = parse_ini_file($file, true);

            return [
                'host' => isset($ini['host']) ? $ini['host'] : '',
                'username' => isset($ini['username']) ? $ini['username'] : '',
                'password' => isset($ini['password']) ? $ini['password'] : '',
                'secure' => isset($ini['secure']) ? $ini['secure'] : 'no',
                'port' => isset($ini['port']) ? (int)$ini['port'] : 25,
                'siteName' => isset($ini['siteName']) ? $ini['siteName'] : '',
                'to' => isset($ini['to']) ? $ini['to'] : '',
                'subject' => isset($ini['subject']) ? $ini['subject'] : 'Обратная связь'
            ];
        } else {
            if (ENVIRONMENT == 'dev') {
                throw new \Exception('Не найден файл настроек smtp.ini');
            }
        }

        return false;
    }
}