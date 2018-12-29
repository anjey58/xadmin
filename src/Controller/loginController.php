<?php

namespace anjey\xadmin\Controller;

use Pagekit\Application as App;
use Pagekit\Auth\Auth;

class loginController
{
    /**
     * @Route("/", methods="GET", defaults={"loginurl" = ""})
     * @Route("/{loginurl}", name="loginurl", methods="GET")
     * @Request({"redirect": "string", "message": "string", "loginurl": "string"})
     */
    public function indexAction($redirect = '', $message = '', $loginurl = '')
    {
        if (App::user()->isAuthenticated()) {
            return App::redirect('@system');
        }

        $masterurllogin=App::config('xadmin')['URLLOGIN']; // чтение url-адреса входа в панель администратора из таблицы "system_config"
        if (!empty($masterurllogin) && $loginurl != $masterurllogin) { // проверка url-адресов
            App::abort(404, __('Page not found.'));
        } else {
            return [
                '$view' => [
                    'title'  => __('Login'),
                    'name'   => 'system/theme:views/login.php',
                    'layout' => false
                ],
                'last_username' => App::session()->get(Auth::LAST_USERNAME),
                'redirect' => $redirect ?: App::url('@system'),
                'message' => $message
            ];
        }
    }
}