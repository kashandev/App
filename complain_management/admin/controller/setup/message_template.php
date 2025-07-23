<?php

class ControllerSetupMessageTemplate extends HController
{

    protected function getAlias()
    {
        return 'setup/message_template';
    }

    protected function getPrimaryKey()
    {
        return 'setting_id';
    }

    protected function init()
    {
        $this->model[$this->getAlias()] = $this->load->model('common/setting');
        $this->data['lang'] = $this->load->language('setup/message_template');
        $this->document->setTitle($this->data['lang']['heading_title']);
        $this->data['token'] = $this->session->data['token'];
    }

    public function index()
    {
        $this->redirect($this->url->link($this->getAlias() . '/update', 'token=' . $this->session->data['token'] . '&school_id=' . $this->session->data['school_id'], 'SSL'));
    }

    protected function getForm()
    {
        parent::getForm();

        $filter = array(
            'company_id' => $this->session->data['company_id'],
            'company_branch_id' => $this->session->data['company_branch_id'],
            'fiscal_year_id' => $this->session->data['fiscal_year_id'],
            'module' => 'setup',
        );
        $results = $this->model[$this->getAlias()]->getRows($filter);
        foreach ($results as $result) {
            if($result['field']=='job_order_message_box') {
                $this->data[$result['field']] = $result['value'];
            } elseif($result['field']=='estimate_message_box') {
                $this->data[$result['field']] = $result['value'];
            } elseif($result['field']=='sale_invoice_message_box') {
                $this->data[$result['field']] = $result['value'];
            } else {
                $this->data[$result['field']] = $result['value'];
            }
        }

        $this->data['action_update'] = $this->url->link($this->getAlias() . '/update', 'token=' . $this->session->data['token'] . 'SSL');
        $this->data['action_cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'] . 'SSL');
        $this->data['action_validate_name'] = $this->url->link($this->getAlias() . '/validateName', 'token=' . $this->session->data['token'] . '&school_id=' . $this->request->get['school_id']);

        $this->data['CN'] = '&lt;CN&gt; (Customer Name)';
        $this->data['JN'] = '&lt;JN&gt; (Job Order Number)';
        $this->data['JAMT'] = '&lt;JAMT&gt; (Job Order Amount)';
        $this->data['ESTN'] = '&lt;ESTN&gt; (Estimate Number)';
        $this->data['ESTAMT'] = '&lt;ESTAMT&gt; (Estimate Amount)';
        $this->data['SIN'] = '&lt;SIN&gt; (Sale Invoice Number)';
        $this->data['SINAMT'] = '&lt;SINAMT&gt; (Sale Invoice Amount)';


        // $this->data['strValidation'] = "{
        //     'rules':{
        //         'purchase_discount_account_id': {'required':true},
        //         'sale_discount_account_id': {'required':true},
        //         'sale_tax_account_id': {'required':true},
        //         'withholding_tax_account_id': {'required':true},
        //         'gr_ir_account_id': {'required':true},
        //         'setup_account_id[]': {'required':true},
        //         'revenue_account_id[]': {'required':true},
        //         'cogs_account_id[]': {'required':true},
        //         'adjustment_account_id[]': {'required':true},
        //         'cartage_account_id': {'required':true},
        //      },
        // }";


        $this->response->setOutput($this->render());
    }

    public function update() {
        $this->init();

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateUpdate()) {
            $this->db->beginTransaction();
            $id = $this->updateData($this->request->post);
            $this->db->commit();

            $this->session->data['success'] = $this->language->get('success_update');

            $this->updateRedirect($id, $this->request->post);
        }
        $this->data['isEdit'] = 1;
        $this->getForm();
    }

    protected function updateData($data) {
        $this->model['setting'] = $this->load->model('common/setting');
        $this->model['setting']->deleteBulk($this->getAlias(), array('company_id' => $this->session->data['company_id'], 'company_branch_id' => $this->session->data['company_branch_id'], 'fiscal_year_id' => $this->session->data['fiscal_year_id'], 'module' => 'setup'));
        foreach($data as $field => $value) {
            if(is_array($value)) {
                foreach($value as $v) {
                    $insert_data = array(
                        'company_id' => $this->session->data['company_id'],
                        'company_branch_id' => $this->session->data['company_branch_id'],
                        'fiscal_year_id' => $this->session->data['fiscal_year_id'],
                        'module' => 'setup',
                        'field' => $field,
                        'value' => $v,
                    );
                    $this->model[$this->getAlias()]->add($this->getAlias(), $insert_data);
                }
            } else {
                $insert_data = array(
                    'company_id' => $this->session->data['company_id'],
                    'company_branch_id' => $this->session->data['company_branch_id'],
                    'fiscal_year_id' => $this->session->data['fiscal_year_id'],
                    'module' => 'setup',
                    'field' => $field,
                    'value' => $value,
                );
                $this->model[$this->getAlias()]->add($this->getAlias(), $insert_data);
            }
        }
        return $this->session->data['company_branch_id'];

    }
}

?>