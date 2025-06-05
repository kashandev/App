<?php

class ModelInventorySaleInvoice extends HModel {

    protected function getTable() {
        return 'ins_sale_invoice';
    }

    protected function getView() {
        return 'vw_ins_sale_invoice';
    }

}

?>