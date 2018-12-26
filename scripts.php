<?php

return [
    // --------------- УДАЛЕНИЕ ---------------
    'uninstall' => function ($app) {
        $app['config']->remove('xadmin'); // удаление из "system_config"
    },
];