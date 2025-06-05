<?php

class ControllerSetupSetting extends HController
{
    protected function getAlias()
    {
        return 'setup/setting';
    }
    protected function getPrimaryKey()
    {
        return 'setting_id';
    }
    protected function init()
    {
        $this->model[$this->getAlias()] = $this->load->model('common/setting');
        $this->data['lang'] = $this->load->language('setup/setting');
        $this->document->setTitle($this->data['lang']['heading_title']);
        $this->data['token'] = $this->session->data['token'];
    }

    public function index()
    {
        $this->redirect($this->url->link($this->getAlias() . '/update', 'token=' . $this->session->data['token'] . '&setting_id=' . $this->session->data['setting_id'], 'SSL'));
    }
    protected function getForm()
    {
        parent::getForm();

        $arrBreadCrumbs = explode('/', $this->getAlias());
        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->data['lang']['breadcrumb_dashboard'],
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'class' => 'fa fa-home',
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->data['lang']['breadcrumb_update'],
            'href' => $this->url->link($this->getAlias().'/update', 'token=' . $this->session->data['token'].'&'.$this->getPrimaryKey().'='.$this->request->get[$this->getPrimaryKey()], 'SSL'),
            'separator' => ' :: '
        );

        $this->model['image'] = $this->load->model('tool/image');
        $this->data['no_image'] = $this->model['image']->resize('no_logo.jpg', 300, 100);

        $filter = array(
            'group' => 'setting',

        );
        $results = $this->model[$this->getAlias()]->getRows($filter);
        //d(array($filter, $results), true);
        foreach ($results as $result) {
           $this->data[$result['key']] = $result['value'];
        }


        if ($this->data['company_logo'] && file_exists(DIR_IMAGE . $this->data['company_logo']) && is_file(DIR_IMAGE . $this->data['company_logo'])) {
            $this->data['src_company_image'] = $this->model['image']->resize($this->data['company_logo'], 300, 100);
        } else {
            $this->data['src_company_image'] = $this->model['image']->resize('no_logo.jpg', 300, 100);
        }
        //d($this->data, true);

        $this->data['action_update'] = $this->url->link($this->getAlias() . '/update', 'token=' . $this->session->data['token'] . 'SSL');

        $this->data['strValidation'] = "{
            'rules':{
                'email': {'required':true, 'email':true},
                'mail_welcome_from': {'required':true, 'email':true},
                'mail_welcome_reply_to': {'email':true},
                'mail_new_ticket_from': {'required':true, 'email':true},
                'mail_new_ticket_reply_to': {'email':true},
                'mail_support_ticket_from': {'required':true, 'email':true},
                'mail_support_ticket_reply_to': {'email':true},
                'mail_close_ticket_from': {'required':true, 'email':true},
                'mail_close_ticket_reply_to': {'email':true},
            },
        }";

        $this->response->setOutput($this->render());
    }

    protected function updateData($primary_key, $data) {
        $file = $this->request->files['company_image'];
        $check = getimagesize($file["tmp_name"]);
        /*d($check, true);*/
        if($check !== false) {
            $file_extension = pathinfo($file['name'],PATHINFO_EXTENSION);
            $file_name = str_replace('.'.$file_extension,'', $file['name']);
            $target_file = $file_name.'.'.md5(date('YmdHis')).'.'.$file_extension;

            $upload = move_uploaded_file($file['tmp_name'], DIR_IMAGE . $target_file);
            if($upload) {
                $data['company_logo'] = $target_file;
            }
        }

        $this->model['setting'] = $this->load->model('common/setting');
        $this->model['setting']->deleteBulk($this->getAlias(), array('group' => 'setting'));

        foreach($data as $field => $value) {
            if(is_array($value)) {
                foreach($value as $v) {
                    $insert_data = array(
                        'group' => 'setting',
                        'key' => $field,
                        'value' => $v,
                    );
                    $this->model[$this->getAlias()]->add($this->getAlias(), $insert_data);
                }
            } else {
                $insert_data = array(
                    'group' => 'setting',
                    'key' => $field,
                    'value' => $value,
                );
                $this->model[$this->getAlias()]->add($this->getAlias(), $insert_data);
            }
        }


    }

}

?>