<?php

class ModelProductionBOMDetail extends HModel {

    protected function getTable() {
        return 'bom_detail';
    }

    protected function getView() {
        return 'vw_bom_detail';
    }

}

?>