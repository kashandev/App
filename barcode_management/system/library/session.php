<?php

final class Session {

    public $data = array();

    public function __construct($name='invend') {
        if (!session_id()) {
            ini_set('session.use_cookies', 'On');
            ini_set('session.use_trans_sid', 'On');

            session_set_cookie_params(86400, '/');
            session_name($name);
            session_start();
        }

        $this->data = & $_SESSION;
    }

}

?>