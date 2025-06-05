<?php

class ControllerCommonLock extends Controller {

    public function index() {
        //d($this->session->data, true);
        $this->data['lang'] = $this->load->language('common/lock');
        $this->document->setTitle($this->language->get('heading_title'));

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $this->data['base'] = HTTPS_BASE;
        } else {
            $this->data['base'] = HTTP_BASE;
        }

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->session->data['token'] = md5(mt_rand());

            //d($this->session->data, true);
            $this->redirect($this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'));
        }

        if (isset($this->error['error_warning'])) {
            $this->data['error_warning'] = $this->error['error_invalid_login'];
        }
        elseif (isset($this->error['warning'])) {
            //d($this->error['warning'],true);
            $this->data['error_warning'] = $this->error['warning'];
        }

        $this->data['action'] = $this->url->link('common/lock', '', 'SSL');
        $this->data['login_id'] = $this->session->data['login_id'];
/*        d($this->session->data,true);*/
        $this->model['image'] = $this->load->model('tool/image');
        $this->data['no_image'] = $this->model['image']->resize('no_user.jpg', 300, 300);

       /* if ($this->data['user_image'] && file_exists(DIR_IMAGE . $this->data['user_image']) && is_file(DIR_IMAGE . $this->data['user_image'])) {
            $this->data['src_user_image'] = $this->model['image']->resize($this->data['user_image'], 100, 100);
        } else {
            $this->data['src_user_image'] = $this->model['image']->resize('no_user.jpg', 100, 100);
        }*/


        if($this->session->data['user_image'] && file_exists(DIR_IMAGE.$this->session->data['user_image'])) {
            $user_image =  $this->session->data['user_image'];
        } else {
            $user_image =  'no_user.jpg';
        }
        $this->data['user_image'] = $this->model['image']->resize($user_image,120,120);
        $this->data['user_name'] = $this->session->data['user_name'];

        if (isset($this->request->post['login_password'])) {
            $this->data['login_password'] = $this->request->post['login_password'];
        } else {
            $this->data['login_password'] = '';
        }


        if (isset($this->request->get['route'])) {
            $route = $this->request->get['route'];

            unset($this->request->get['route']);

            if (isset($this->request->get['token'])) {
                unset($this->request->get['token']);
            }

            $url = '';

            if ($this->request->get) {
                $url .= http_build_query($this->request->get);
            }

            $this->data['redirect'] = $this->url->link($route, $url, 'SSL');
        } else {
            $this->data['redirect'] = '';
        }
        //d($this->data, true);
        $this->template = 'common/lock.tpl';

        $this->response->setOutput($this->render());
    }

    private function validate() {
        if (isset($this->request->post['login_id']) && isset($this->request->post['login_password']))
        {
            $this->model['user'] = $this->load->model('user/user');
            $login_id = $this->request->post['login_id'];
            $login_password = md5($this->request->post['login_password']);
            $user = $this->model['user']->getRow(array('login_id' => $login_id, 'login_password' => $login_password));
            //d(array($this->request->post, $login_id, $login_password, $user), true);
            if($user) {
                $this->model['user']->edit('common/login', $user['user_id'], array('last_login_date' => date('Y-m-d H:i:s')));
                $this->model['user_permission'] = $this->load->model('user/user_permission');
                $user_permission = $this->model['user_permission']->getRow(array('user_permission_id' => $user['user_permission_id']));

                $data = $user;
                $data['permissions'] = unserialize($user_permission['permission']);
                //d($data, true);
                $this->user->set($data);
                $this->session->data['user_id'] = $user['user_id'];
                $this->session->data['login_id'] = $user['login_id'];
                $this->session->data['user_name'] = $user['user_name'];
                $this->session->data['user_image'] = $user['user_image'];
                //d($this->session->data, true);
            } else {

                $this->error['warning'] = $this->data['lang']['error_invalid_login'];

             /*   d($this->error['warning'],true);*/
            }

        } else {
            $this->error['warning'] = $this->data['lang']['error_invalid_login'];

        }
        /*d($this->error,true);*/
        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}

?>