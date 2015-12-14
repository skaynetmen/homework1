<?php

namespace Skaynetmen\Homework1\Models;

use Skaynetmen\Homework1\Core\Model;

class Feedback extends Model
{
    public function msg($name, $email, $message)
    {
        $message = strip_tags($message);

        $text = "<h3>{$name}</h3>";
        $text .= "<h4>{$email}</h4>";
        $text .= "<p>{$message}</p>";

        return $text;
    }

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