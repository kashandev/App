<?php

final class User {

    private $user_id;
    private $login_id;
    private $user_permission_id;
    private $retailer_id;
    private $user_name;
    private $user_image;
    private $colour_theme;
    private $ip;
    private $permissions = array();

    public function set($data) {
        //d($data, true);
        $permissions = $data['permissions'];
        unset($data['permissions']);

        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        if (is_array($permissions)) {
            foreach ($permissions as $key => $value) {
                $this->permissions[$key] = $value;
            }
        }
    }

    public function logout() {
        unset($this->session->data['user_id']);

        $this->user_id = '';
        $this->retailer_id = '';
        $this->login_name = '';
        $this->user_name = '';
        $this->user_image = '';

        session_destroy();
    }

    public function hasPermission($key, $value) {
        if (isset($this->permissions[$value][$key])) {
//            return in_array($value, $this->permission[$key]);
            return $this->permissions[$value][$key];
        } else {
            return false;
        }
    }

    public function getViewPermissions() {
        $arrPermission = array();
        foreach($this->permissions as $route => $permission) {
            if(isset($permission['view'])) {
                $arrPermission[$route] = $permission['view'];
            } else {
                $arrPermission[$route] = 0;
            }
        }
        return $arrPermission;
    }

    public function isLogged() {
        //d(array($this->user_id, $this->employee_id, $this->username));
        return $this->user_id;
    }

    public function getId() {
        return $this->user_id;
    }

    public function getLoginID() {
        return $this->login_id;
    }

    public function getUserName() {
        return $this->user_name;
    }

    public function getUserPermissionId() {
        return $this->user_permission_id;
    }

    public function getAllPermission() {
        return $this->permissions;
    }

    public function getIP() {
        return $this->ip;
    }

    public function getCompanyId() {
        return $this->company_id;
    }

    public function getUserImage() {
        return $this->user_image;
    }

    public function getTheme() {
        return $this->colour_theme;
    }

    public function getData() {
        $data = array();
        $data['user_id'] = $this->user_id;
        $data['user_permission_id'] = $this->user_permission_id;
        $data['retailer_id'] = $this->retailer_id;
        $data['login_id'] = $this->login_id;
        $data['user_name'] = $this->user_name;
        $data['user_image'] = $this->user_image;
        $data['permissions'] = $this->permissions;
        $data['colour_theme'] = $this->colour_theme;

        return $data;
    }

}

?>