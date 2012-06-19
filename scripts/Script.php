<?php

require_once(dirname(__file__).'/../iafbm/lib/xfm/lib/Util/Script.php');

abstract class iafbmScript extends xScript {

    function setup_bootstrap() {
        // Instanciates the project specific bootstrap
        require_once(dirname(__file__).'/../iafbm/lib/iafbm/xfm/Bootstrap.php');
        new Bootstrap();
        // Sets a default 'script' username
        $_SERVER['HTTP_SHIB_PERSON_UID'] = 'update-script';
        $_SERVER['HTTP_SHIB_SWISSEP_HOMEORGANIZATION'] = 'localhost';
        $_SERVER['HTTP_SHIB_CUSTOM_UNILMEMBEROF'] = 'local-superuser';
        xContext::$auth->set_from_aai();
    }
}

?>