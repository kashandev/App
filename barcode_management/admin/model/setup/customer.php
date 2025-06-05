<?php

class ModelSetupCustomer extends HModel {

    protected function getTable() {
        return 'core_customer';
    }

    protected function getView() {
        return 'vw_core_customer';
    }

}

?>