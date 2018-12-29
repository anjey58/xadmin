<?php

use Pagekit\Application as App;

return [
    // --------------- ОСНОВНЫЕ ---------------
    'name' => 'xadmin', // уникальное имя, идентифицирующий модуль
    'type' => 'extension', // тип модуля

    // --------------- РЕГИСТРАЦИЯ ПРОСТРАНСТВ ИМЕН ---------------
    'autoload' => [
        'anjey\\xadmin\\' => 'src'
    ],

    // --------------- МАРШРУТ КОНТРОЛЛЕРА ---------------
    'routes' => [
        // -----основной контроллер
        '/xadmin' => [
            'name' => '@xadmin/admin',
            'controller' => 'anjey\\xadmin\\Controller\\indexController'
        ],
        // -----для работы с БД
        '/xadmin/bd' => [
            'name' => '@xadmin/bd',
            'controller' => 'anjey\\xadmin\\Controller\\bdController'
        ],
        // -----управление url-адресом входа в панель администратора
        '/admin' => [
            'name' => '@xadmin',
            'controller' => 'anjey\\xadmin\\Controller\\loginController'
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
    'events' => [
        // -----начало выполнения запросов
        'request' => function ($event, $request) use ($app) {
            if ($request->attributes->get('_route') == '@system/login') { // если маршрут авторизации
                $protocol=(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                if (strpos($request->headers->get('referer'), $protocol . $request->getHost() . '/admin/') == 0) { // если предыдущаю страница панель администратора
                    //$event->setResponse($app->redirect('@page/1'), [], 301);
                    $event->setResponse($app->redirect('/'), [], 301);
                } else {
                    App::abort(404, __('Page not found.'));
                }
            }
        }
    ],

    // --------------- СОКРАЩЕНИЯ ---------------
    'resources' => [
        'xadmin:' => '',
    ]
];