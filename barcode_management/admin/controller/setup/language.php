<?php

class ControllerSetupLanguage extends HController
{

    protected function getAlias()
    {
        return 'setup/language';
    }

    protected function getPrimaryKey()
    {
        return 'language_id';
    }

    protected function getList()
    {
        parent::getList();

        $this->data['action_ajax'] = $this->url->link($this->getAlias() . '/getAjaxLists', 'token=' . $this->session->data['token'], 'SSL');
        $this->response->setOutput($this->render());
    }

    public function getAjaxLists()
    {

        $lang = $this->load->language('setup/language');
        //d($lang, true);
        $this->model[$this->getAlias()] = $this->load->model($this->getAlias());
        // d($this->model[$this->getAlias()],true);
        $data = array();
        $aColumns = array('action','code','name','created_at');

        /*
         * Paging
         */
        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $data['criteria']['start'] = $_GET['iDisplayStart'];
            $data['criteria']['limit'] = $_GET['iDisplayLength'];
        }

        /*
         * Ordering
         */
        $sOrder = "";
        if (isset($_GET['iSortCol_0'])) {
            $sOrder = " ORDER BY  ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder .= "`" . $aColumns[intval($_GET['iSortCol_' . $i])] . "` " .
                        ($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
                }
            }

            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == " ORDER BY") {
                $sOrder = "";
            }
            $data['criteria']['orderby'] = $sOrder;
        }


        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $arrWhere = array();
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $arrSSearch = array();
            for ($i = 0; $i < count($aColumns); $i++) {
                if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch'] != '') {
                    $arrSSearch[] = "LOWER(`" . $aColumns[$i] . "`) LIKE '%" . $this->db->escape(strtolower($_GET['sSearch'])) . "%'";
                }
            }
            if(!empty($arrSSearch)) {
                $arrWhere[] = '(' . implode(' OR ', $arrSSearch) . ')';
            }
        }

        /* Individual column filtering */
        for ($i = 0; $i < count($aColumns); $i++) {
            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
                $arrWhere[] = "LOWER(`" . $aColumns[$i] . "`) LIKE '%" . $this->db->escape(strtolower($_GET['sSearch_' . $i])) . "%' ";
            }
        }

        if (!empty($arrWhere)) {
            //$data['filter']['RAW'] = substr($sWhere, 5, strlen($sWhere) - 5);
            $data['filter']['RAW'] = implode(' AND ', $arrWhere);
        }

        //d($data, true);
        $results = $this->model[$this->getAlias()]->getLists($data);
        $iFilteredTotal = $results['total'];
        $iTotal = $results['table_total'];
        //d(array($data, $results), true);


        /*
         * Output
         */
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );

        foreach ($results['lists'] as $aRow) {
            $row = array();

            $action_update = $this->url->link($this->getAlias() . '/update', 'token=' . $this->session->data['token'] . '&' . $this->getPrimaryKey() . '=' . $aRow[$this->getPrimaryKey()], 'SSL');
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == 'action') {
                    if($aRow['language_id']!=1) {
                        $row[] = '<input type="checkbox" name="selected[]" value="' . $aRow[$this->getPrimaryKey()] . '" />';
                    } else {
                        $row[] = '';
                    }
                } elseif ($aColumns[$i] == 'name') {
                    $row[] = '<a href="'.$action_update.'" title="'.$lang['edit'].'">'.$aRow['name'].'</a>';
                } elseif ($aColumns[$i] == 'created_at') {
                    $row[] = stdDateTime($aRow['created_at']);
                } else {
                    $row[] = $aRow[$aColumns[$i]];
                }

            }
            $output['aaData'][] = $row;
        }

        echo json_encode($output);
    }

    protected function getForm()
    {
        parent::getForm();

        if (isset($this->request->get['language_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $result = $this->model[$this->getAlias()]->getRow(array($this->getPrimaryKey() => $this->request->get[$this->getPrimaryKey()]));

            foreach ($result as $field => $value) {
                $this->data[$field] = $value;
            }
        }

        $this->data['href_get_documents'] = $this->url->link($this->getAlias() . '/getDocuments', 'token=' . $this->session->data['token'] . '&language_id=' . $this->request->get['language_id']);
        $this->data['href_get_variables'] = $this->url->link($this->getAlias() . '/getVariables', 'token=' . $this->session->data['token'] . '&language_id=' . $this->request->get['language_id']);

        $this->data['action_validate_code'] = $this->url->link($this->getAlias() . '/validateCode', 'token=' . $this->session->data['token'] . '&language_id=' . $this->request->get['language_id']);
        $this->data['action_validate_name'] = $this->url->link($this->getAlias() . '/validateName', 'token=' . $this->session->data['token'] . '&language_id=' . $this->request->get['language_id']);
        $this->data['strValidation'] = "{
            'rules':{
                'code': {'required':true, 'remote':  {url: '" . $this->data['action_validate_code'] . "', type: 'post'}},
                'name': {'required':true, 'remote':  {url: '" . $this->data['action_validate_name'] . "', type: 'post'}},
            },
        }";

        $this->response->setOutput($this->render());
    }

    public function getDocuments() {
        $module = $this->request->post['module'];
        $this->model['variable'] = $this->load->model('setup/variable');
        $documents = $this->model['variable']->getDocuments($module);
        $html = '';
        foreach($documents as $document) {
            $html .= '<option value="'.$document['document'].'">'.$document['document'].'</option>';
        }
        $json = array(
            'success' => true,
            'html' => $html
        );

        echo json_encode($json);
    }

    public function getVariables() {
        $language_id = $this->request->get['language_id'];
        $module = $this->request->post['module'];
        $document = $this->request->post['document'];
        $this->model['language_variable'] = $this->load->model('setup/language_variable');
        $variables = $this->model['language_variable']->getVariables($language_id, $module, $document);
        $html = '';
        //d($variables, true);
        foreach($variables as $variable) {
            $html .= '<tr>';
            $html .= '<td>';
            $html .= '<input type="hidden" id="language_variable_'.$variable['variable_id'].'_variable_id" name="language_variables['.$variable['variable_id'].'][variable_id]" value="'.$variable['variable_id'].'" />';
            $html .= '<input type="text" class="form-control" id="language_variable_'.$variable['variable_id'].'_label" name="language_variables['.$variable['variable_id'].'][label]" value="'.$variable['label'].'" readonly />';
            $html .= '</td>';
            if($language_id != 1){
            $html .= '<td>';
            $html .= '<input type="text" class="form-control" id="language_variable_'.$variable['variable_id'].'_value_en" name="language_variables['.$variable['variable_id'].'][value_en]" value="'.$variable['en_value'].'" readonly/>';
            $html .= '</td>';
            }
            $html .= '<td>';
            $html .= '<input type="text" class="form-control" id="language_variable_'.$variable['variable_id'].'_value" name="language_variables['.$variable['variable_id'].'][value]" value="'.$variable['value'].'" />';
            $html .= '</td>';
            $html .= '</tr>';
        }
        $json = array(
            'success' => true,
            'html' => $html
        );

        echo json_encode($json);
    }

    public function validateCode()
    {
        $code = $this->request->post['code'];
        $language_id = $this->request->get['language_id'];
        $this->load->language('setup/language');
        if ($code) {
            $this->model['language'] = $this->load->model('setup/language');
            $where = "LOWER(`code`)='".strtolower($code)."' AND `language_id` != '".$language_id."'";
            $language = $this->model['language']->getRow($where);
            if ($language) {
                echo json_encode($this->language->get('error_duplicate_code'));
            } else {
                echo json_encode("true");
            }
        } else {
            echo json_encode($this->language->get('error_invalid'));
        }
        exit;
    }

    public function validateName()
    {
        $name = $this->request->post['name'];
        $language_id = $this->request->get['language_id'];
        $this->load->language('setup/language');
        if ($name) {
            $this->model['language'] = $this->load->model('setup/language');
            $where = "LOWER(`name`)='".strtolower($name)."' AND `language_id` != '".$language_id."'";
            $language = $this->model['language']->getRow($where);
            if ($language) {
                echo json_encode($this->language->get('error_duplicate_name'));
            } else {
                echo json_encode("true");
            }
        } else {
            echo json_encode($this->language->get('error_invalid'));
        }
        exit;
    }

    protected function insertData($data) {
        $this->model['language_variable'] = $this->load->model('setup/language_variable');
        $language_id = $this->model[$this->getAlias()]->add($this->getAlias(), $data);
        foreach($data['language_variables'] as $variable) {
            $variable['language_id'] = $language_id;

            $this->model['language_variable']->add($this->getAlias(), $variable);
        }

        return $language_id;
    }

    protected function insertRedirect($id, $data) {
        $this->redirect($this->url->link($this->getAlias().'/update', 'token=' . $this->session->data['token'].'&language_id='.$id, 'SSL'));
    }

    protected function updateData($primary_key, $data) {
        $this->model['language_variable'] = $this->load->model('setup/language_variable');
        $this->model['language_variable']->deleteBulk($this->getAlias(), array('language_id' => $primary_key, 'module' => $data['module'], 'document' => $data['document']));

        $language_id = $this->model[$this->getAlias()]->edit($this->getAlias(), $primary_key, $data);
        foreach($data['language_variables'] as $variable) {
            $variable['language_id'] = $language_id;

            $this->model['language_variable']->add($this->getAlias(), $variable);
        }

        return $language_id;
    }

    protected function updateRedirect($id, $data) {
        $this->redirect($this->url->link($this->getAlias().'/update', 'token=' . $this->session->data['token'].'&language_id='.$id, 'SSL'));
    }


}

?>