<?php

namespace Skaynetmen\Homework1\Models;


use ReCaptcha\ReCaptcha;
use Skaynetmen\Homework1\Core\Model;

class Recapthca extends Model
{
    private $recaptcha;

    public function __construct()
    {
        $config = $this->getRecapthcaConfig();

        $this->recaptcha = new ReCaptcha($config['secret']);
    }

    private function getRecapthcaConfig()
    {
        $file = BASEPATH . 'config/recaptcha.ini';

        if (file_exists($file)) {
            $ini = parse_ini_file($file, true);

            return [
                'secret' => isset($ini['secret']) ? $ini['secret'] : ''
            ];
        } else {
            if (ENVIRONMENT == 'dev') {
                throw new \Exception('Не найден файл настроек recaptcha.ini');
            }
        }

        return false;
    }

    public function check($googleResponse)
    {
        $response = $this->recaptcha->verify($googleResponse, $_SERVER['REMOTE_ADDR']);

        return $response->isSuccess();
    }
}