<?php

namespace Pagekit\xadmin\Controller;

use Pagekit\Application as App;

/**
 * @Access(admin=true)
 */
class indexController
{
    // --------------- ОБРАБОТЧИК По УМОЛЧАНИЮ ---------------
    /**
     * @Access("xadmin: edit")
     */
    public function indexAction() {
        $options=bdController::loadoptionsAction(); // загрузка настроек
        $urllogin=(empty($options['URLLOGIN'])) ? '' : $options['URLLOGIN']; // url-адрес входа в панель администратора
        $protocol=(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domain=$protocol . $_SERVER['HTTP_HOST'] . '/';
        // -----
        return [
            // -----представление
            '$view' => [
                'title' => 'XAdmin', // загаловок окна
                'name' => 'xadmin:views/admin/index.php' // файл представления
            ],
            // -----данные
            '$data' => [
                'urllogin' => $urllogin, // url-адрес входа в панель администратора
                'domain' => $domain, // доменное имя
            ]
        ];
    }
}
