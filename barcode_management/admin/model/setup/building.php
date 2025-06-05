<?php

class ModelSetupBuilding extends HModel{


    protected function getTable() {
        return 'core_building';
    }

    public function getView(){
        return 'vw_core_building';
    }

}