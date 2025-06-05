<?php

class ModelSetupSetting extends HModel {
    protected $isAdmin = true;

    protected function getAlias() {
        return 'setup/setting';
    }

    protected function getTable() {
        return 'core_setting';
    }
    protected function getPrimaryKey() {
        return 'setting_id';
    }

}

?>