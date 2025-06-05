<?php

class ControllerCommonPageHeader extends Controller {

    public function index() {
        $this->data['lang'] = $this->load->language('common/page_header');
        $this->model['image'] = $this->load->model('tool/image');
        $this->model['setting'] = $this->load->model('common/setting');
        $this->model['language'] = $this->load->model('setup/language');

        $this->data['languages'] = $this->model['language']->getRows();
        $this->data['language_code'] = $this->session->data['language_code'];

        $settings = $this->model['setting']->getRows();
        foreach($settings as $setting) {
            if($setting['serialize']==1) {
                $this->data[$setting['field']] = unserialize($setting['value']);
            } else {
                $this->data[$setting['field']] = $setting['value'];
            }
        }
        //$this->data['company_logo']= HTTP_IMAGE.'logo2-light_2x.png';
        $this->data['company_logo']= '<span class="logo_white">I</span><span class="logo_white">N</span><span class="logo_red">V</span><span class="logo_green">E</span><span class="logo_blue">N</span><span class="logo_yellow">D</span><span class="logo_white">i</span><span class="logo_white">P</span><span class="logo_white">O</span><span class="logo_white">S</span>';

        if($this->session->data['user_image'] && file_exists(DIR_IMAGE.$this->session->data['user_image'])) {
            $user_image =  $this->session->data['user_image'];
        } else {
            $user_image =  'no_user.jpg';
        }

        $this->data['branch_name'] = $this->session->data['company_branch_name'];

        $this->data['user_image'] = $this->model['image']->resize($user_image,50,50);
        $this->data['user_name'] = $this->session->data['user_name'];

        $base_currency_id = $this->data['base_currency_id'];
        $this->model['currency'] = $this->load->model('setup/currency');
        $currency = $this->model['currency']->getRow(array('currency_id' => $base_currency_id));
        $this->session->data['base_currency_id'] = $currency['currency_id'];
        $this->session->data['base_currency_name'] = $currency['name'];

        //d($this->data['user_name'],true);
        //d(array($user_image, $this->data['user_image']), true);
        $this->data['href_logout'] = $this->url->link('common/logout', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_user_profile'] = $this->url->link('user/user_profile', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_setting'] = $this->url->link('setup/setting', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_lock'] = $this->url->link('common/lock', 'token=' . $this->session->data['token'], 'SSL');

        $route = explode('/',$this->request->get['route']);
        $this->data['href_redirect'] = $this->url->link($route[0].'/'.$route[1], 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_language'] = $this->url->link('common/home/updateLanguage', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['href_session_status'] = $this->url->link('common/page_header/getSessionStatus', 'token=' . $this->session->data['token'], 'SSL');

        $this->session->data['session_expires'] = date('Y-m-d H:i:s', strtotime("+30 minutes"));

        $this->template = 'common/page_header.tpl';
        $this->render();
    }

    public function getSessionStatus() {
        $session_expires = $this->session->data['session_expires'];
        $current_time = date('Y-m-d H:i:s');
        if($current_time>$session_expires) {
            $is_session_expires = 1;
        } else {
            $is_session_expires = 0;
        }

        $datetime1 = new DateTime($session_expires);
        $datetime2 = new DateTime($current_time);
        $interval = $datetime1->diff($datetime2);
        $elapsed = $interval->format('%i minutes %s seconds');

        $json = array(
            'success' => true,
            'current_time' => $current_time,
            'session_expires' => $session_expires,
            'is_session_expires' => $is_session_expires,
            'interval' => $interval,
            'elapsed' => $elapsed
        );

        header('Content-Type: application/json');
        echo json_encode($json);

    }
}

?>