<?php

class ControllerCommonHome extends Controller {

    protected function getAlias() {
        return 'common/home';
    }

    public function index() {
        $this->data['lang'] = $this->load->language('common/home');

        $this->document->setTitle($this->language->get('heading_title'));
        $this->data['heading_title'] = $this->language->get('heading_title');
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $this->data['base'] = HTTPS_BASE;
        } else {
            $this->data['base'] = HTTP_BASE;
        }

        if (isset($this->session->data['error'])) {
            $this->data['error_warning'] = $this->session->data['error'];

            unset($this->session->data['error']);
        } elseif (isset($this->session->data['warning'])) {
            $this->data['error_warning'] = $this->session->data['warning'];

            unset($this->session->data['warning']);
        } elseif (isset($this->session->data['error_warning'])) {
            $this->data['error_warning'] = $this->session->data['error_warning'];

            unset($this->session->data['error_warning']);
        } else {
            $this->data['error_warning'] = '';
        }
        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->data['lang']['home'],
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'class' => 'fa fa-home',
            'separator' => false
        );

        $this->data['token'] = $this->session->data['token'];


        $this->template = 'common/home.tpl';
        $this->children = array(
            'common/header',
            'common/column_left',
            //'common/column_right',
            'common/page_header',
            'common/page_footer',
            'common/footer',
        );

        $this->response->setOutput($this->render());
    }

    public function login() {
        if(isset($this->session->data['user_id']) && $this->session->data['user_id']) {
            //d($this->session->data, true);
            $this->model['user'] = $this->load->model('user/user');
            $user = $this->model['user']->getRow(array('user_id' => $this->session->data['user_id']));
            if ($user) {
                $this->model['user_permission'] = $this->load->model('user/user_permission');
                $permissions = $this->model['user_permission']->getRow(array('user_permission_id' => $user['user_permission_id']));
                $data = $user;
                $data['permissions'] = unserialize($permissions['permission']);

                $this->user->set($data);
            } else {
                return $this->forward('common/logout');
            }

        }

        $route = '';

        if (isset($this->request->get['route'])) {
            $part = explode('/', $this->request->get['route']);

            if (isset($part[0])) {
                $route .= $part[0];
            }

            if (isset($part[1])) {
                $route .= '/' . $part[1];
            }
        }

        $ignore = array(
            'common/login',
            'common/preset',
            'common/forgotten',
            'common/filemanager',
            'common/reset',
            'common/reset_password'
        );

        //d(array($this->user->getData(), $this->session->data), true);
        if ((!$this->user->isLogged()) && !in_array($route, $ignore)) {
            return $this->forward('common/logout');
        }

//        $user_restricted_ip = $this->user->getIP();
//        if($user_restricted_ip &&  $user_restricted_ip != $this->request->server['REMOTE_ADDR']) {
//            return $this->forward('common/logout');
//        }
    }

    public function permission() {
//        $sk = $this->config->get('config_security_key');
//        if (!$sk) {
//            return $this->forward('error/security');
//        } else {
//            $arrSK = unserialize(base64_decode($sk));
//            if ($arrSK['server'] == $this->request->server['HTTP_HOST']) {
//                if ($arrSK['expiry_date'] != "") {
//                    if ($arrSK['expiry_date'] < date('Y-m-d')) {
//                        return $this->forward('error/security');
//                    }
//                }
//            } else {
//                return $this->forward('error/security');
//            }
//        }

        if (isset($this->request->get['route'])) {
            $route = '';

            $part = explode('/', $this->request->get['route']);

            if (isset($part[0])) {
                $route .= $part[0];
            }

            if (isset($part[1])) {
                $route .= '/' . $part[1];
            }

            $ignore = array(
                'common/page_header',
                'common/home',
                'common/login',
                'common/lock',
                'common/reset_password',
                'common/preset',
                'common/logout',
                'common/forgotten',
                'common/reset',
                'common/filemanager',
                'common/function',
                'error/not_found',
                'error/permission',
                'error/error'
            );

            if (!in_array($route, $ignore) && !$this->user->hasPermission('view', $route)) {
                return $this->forward('error/permission');
            }
        }
    }

    public function updateLanguage() {
        $post = $this->request->post;
        $this->session->data['language_code'] = $post['language_code'];
        $this->redirect($post['redirect']);
    }
}

?>