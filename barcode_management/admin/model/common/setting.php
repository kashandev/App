<?php

class ModelCommonSetting extends HModel {

    protected function getTable() {
        return 'core_setting';
    }

    protected function getPrimaryKey() {
        return 'setting_id';
    }

}

?>