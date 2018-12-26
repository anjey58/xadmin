<?php

namespace Pagekit\xadmin\Controller;

use Pagekit\Application as App;
use Pagekit\Application\Exception;

/**
 * @Access(admin=true)
 */
class bdController
{
    // --------------- ÇÀÃĞÓÇÊÀ ÍÀÑÒĞÎÅÊ ---------------
    /**
     * @Access("xadmin: edit")
     * @Request(csrf=true)
     */
    public function loadoptionsAction() {
        try {
            $options=App::config('xadmin'); // ÷òåíèå äàííûõ èç òàáëèöû "system_config"
            // -----ğåçóëüòàò
            return $options;
        } catch (Exception $e) {
            return App::abort(400, $e->getMessage());
        }
    }

    // --------------- ÑÎÕĞÀÍÅÍÈÅ ÍÀÑÒĞÎÅÊ ---------------
    /**
     * @Access("xadmin: edit")
     * @Request({"data": "array"}, csrf=true)
     */
    public function saveoptionsAction($data = null) {
        if (empty($data)) {App::abort(400, 'Îøèáêà âõîäíûõ ïàğàìåòğîâ');}
        try {
            // -----ñîõğàíåíèå äàííûõ
            //App::config('xadmin')->set(null, $data);
            App::config('xadmin')->merge($data, true);//->set('URLLOGIN', $data['URLLOGIN']);

            // -----ğåçóëüòàò
            return true;
        } catch (Exception $e) {
            return App::abort(400, $e->getMessage());
        }
    }
}