<?php

class ModelProductionBOM extends HModel {

    protected function getTable() {
        return 'bom';
    }

    protected function getView() {
        return 'vw_bom';
    }

}

?>