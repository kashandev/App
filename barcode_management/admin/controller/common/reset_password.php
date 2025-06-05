<?php

class ControllerCommonResetPassword extends Controller {

    public function index() {
        //d($this->session->data, true);
        $this->data['lang'] = $this->load->language('common/reset_password');
        $this->document->setTitle($this->language->get('heading_title'));

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $this->data['base'] = HTTPS_BASE;
        } else {
            $this->data['base'] = HTTP_BASE;
        }

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->redirect($this->url->link('common/login', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->data['action'] = $this->url->link('common/reset_password', '', 'SSL');
        $this->data['login_id'] = $this->session->data['login_id'];
        $token = $this->request->get['token'];
        $token_data = json_decode(base64_decode($token), true);
        $this->data['user_id'] = $token_data['user_id'];
        $this->data['user_name'] = $token_data['user_name'];
        $this->data['email'] = $token_data['email'];
        $this->template = 'common/reset_password.tpl';

        $this->data['strValidation'] = "{
            'rules':{
                'login_password': {'required': true,'minlength': 8},
                'repeat_password': {'required': true,'equalTo': '#login_password'},
            },
            'messages':{
                'login_password': {'required':'".$this->data['lang']['error_required_password']."','minlength':'".$this->data['lang']['error_password_length']."'},
                'repeat_password': {'required':'".$this->data['lang']['error_required_password']."','equalTo':'".$this->data['lang']['error_mismatch_password']."'},
            },
            'ignore':[]
        }";

        $this->response->setOutput($this->render());
    }

    private function validate() {
        if (isset($this->request->post['login_password']))
        {
            $this->model['user'] = $this->load->model('user/user');

            $user_id = $this->request->post['user_id'];
            $login_password = md5($this->request->post['login_password']);
            $this->model['user']->edit('common/reset_password', $user_id, array('login_password' => $login_password));
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }



}

?>