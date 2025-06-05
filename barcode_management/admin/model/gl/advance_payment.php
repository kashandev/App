<?php

class ModelGLAdvancePayment extends HModel {

    protected function getTable() {
        return 'gla_advance_payment';
    }
    protected function getView() {
        return 'vw_gl_advance_payment';
    }

}

?>