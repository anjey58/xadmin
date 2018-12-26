<?php

use Pagekit\Application as App;
//use Nativerank\Utilities\PagekitLogger as Logger;

return [
    // --------------- ОСНОВНЫЕ ---------------
    'name' => 'xadmin', // уникальное имя, идентифицирующий модуль
    'type' => 'extension', // тип модуля

    // --------------- ГЛАВНАЯ ФУНКЦИЯ ВХОДА ---------------
    /*
    'main' => function (App $app) {
        $app['logxadmin'] = function() {
            return new Logger('Logger', 'xadmin.log');
        };
    },
    */

    // --------------- РЕГИСТРАЦИЯ ПРОСТРАНСТВ ИМЕН ---------------
    'autoload' => [
        'Pagekit\\xadmin\\' => 'src'
    ],

    // --------------- МАРШРУТ КОНТРОЛЛЕРА ---------------
    'routes' => [
        // -----основной контроллер
        '/xadmin' => [
            'name' => '@xadmin/admin',
            'controller' => 'Pagekit\\xadmin\\Controller\\indexController'
        ],
        // -----для работы с БД
        '/xadmin/bd' => [
            'name' => '@xadmin/bd',
            'controller' => 'Pagekit\\xadmin\\Controller\\bdController'
        ],
        // -----управление url-адресом входа в панель администратора
        '/admin' => [
            'name' => '@xadmin',
            'controller' => 'Pagekit\\xadmin\\Controller\\loginController'
        ]
    ],

    // --------------- РАЗРЕШЕНИЯ ---------------
    'permissions' => [
        'xadmin: edit' => [
            'title' => _('Editing the url-address login of the admin panel'),
            'description' => _('Manages access of edit the url-address login of the admin panel'),
            'trusted' => true
        ]
    ],

    // --------------- МЕНЮ ---------------
    'menu' => [
        // -----в панели управления
        'xadmin' => [
            'label' => 'XAdmin', // наименование
            'url' => '@xadmin/admin', // url-адрес модуля по умолчанию (Controller - indexAction)
            'icon' => 'xadmin:icon.png', // иконка в панели управления
            'access' => 'xadmin: edit' // разрешения доступа
        ],
        // -----вкладка "ГЛАВНАЯ"
        'xadmin: index' => [
            'parent' => 'xadmin', // родительское меню
            'url' => '@xadmin/admin', // url-адрес пункта меню (Controller - indexAction)
            'label' => 'Настройки' // наименование
        ],
    ],

    // --------------- EVENTS ---------------
    // https://pagekit.com/docs/developer/events
    // http://symfony.com.ua/doc/current/components/http_kernel.html#component-http-kernel-event-table
    'events' => [
        // -----начало выполнения запросов
        'request' => function ($event, $request) use ($app) {
            //App::logxadmin()->log('Route', [$request->attributes->get('_route') . ' - ' . $request->headers->get('referer')], 'INFO'); // log
            // -----
            if ($request->attributes->get('_route') == '@system/login') { // если маршрут авторизации
                $protocol=(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                if (strpos($request->headers->get('referer'), $protocol . $request->getHost() . '/admin/') == 0) { // если предыдущаю страница панель администратора
                    //$event->setResponse($app->redirect('@page/1'), [], 301);
                    $event->setResponse($app->redirect('/'), [], 301);
                } else {
                    App::abort(404, __('Page not found.'));
                }
            }
        },

        // -----завершенеи выполнения запросов
        //'response' => function ($event, $request, $response) use ($app) {}
    ],

    // --------------- СОКРАЩЕНИЯ ---------------
    'resources' => [
        'xadmin:' => '',
    ]
];