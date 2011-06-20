<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends Base_Controller {

	function __construct() {
		parent::__construct('fb', FALSE);
        $this->load->library('form_validation');
        $this->load->library('nws_auth');
	}

	public function index()
	{
        $this->_check_is_logged_id();
        
        // $value = $this->nws_auth->test();
        $this->load_view(array('view' => 'login_view', 'theme' => 'admin', 'template' => 'basic'));
	
	}
    
    public function login() {

        $result = '';
        $_user = null;
        $data = null;
        
        // check user if already logged in
        if ($this->nws_auth->is_logged_in()) {
            // already logged in
            $id = $this->nws_auth->get_s('id');
            $_user = $this->admin_users_model->get_admin_user_by_id($id);
            // $_user = $this->admin_users_model->get_admin_user_by_id($this->session->userdata('id'));

            if (!empty($_user)) {
                if ($_user->is_activated == 1) {
                    // user is an admin redirect him to the admin pages
                    redirect("/admin");
                    return;
                } else {
                    $result = "'{$_user->full_name}' You are Administrator account is currently inactive!";
                } 

            } else {
                $this->nws_auth->del_s();
            }

        } // end if is_logged_in


        // check if there is post
        if (count($_POST) == 0) {
            if (!empty($result)) $data['result_message'] = $result;

            $this->load_view(array('view' => 'login_view', 'theme' => 'admin', 'template' => 'basic', 'data' => $data));
            return;
        } // end if

        $this->form_validation->set_rules('username', 'Username/Email', 'trim|required');
        $this->form_validation->set_rules('passwrd', 'Password', 'trim|required');

        $result = '';
        
        if ($this->form_validation->run() ) {
            
            // retrive the variables
            $username = $this->input->post('username');
            $password = $this->input->post('passwrd');
            $remember = $this->input->post('remember-me') == 'on';

            if ($this->nws_auth->is_logged_in()) {
                // already logged in
                $id = $this->nws_auth->get_s('id');
                $_user = $this->admin_users_model->get_admin_user_by_id($id);
                // $_user = $this->admin_users_model->get_admin_user_by_id($this->session->userdata('id'));
            } else if ($this->nws_auth->is_logged_in(FALSE)) {
                // logged in, not activated
                $result = 'Account not activated.';
            } else {
                // not yet logged in

                $ret_code = $this->nws_auth->login($username, $password, $remember);
                error_log($ret_code." :LOGGED: ".json_encode($this->session->userdata));
                switch($ret_code) {
                    case LOGIN_OK:
                        // check if the logged in user is an admin
                        $id = $this->nws_auth->get_s('id');
                        $_user = $this->admin_users_model->get_admin_user_by_id($id);
                        error_log($ret_code." :LOGGED user: ".$id);
                        $result = 'Login successful.';
                        break;
                    // this group will fall under invalid username and password
                    // TODO : have separate hadlng for the following codes
                    case LOGIN_ERROR_INVALID_REQUEST:
                    case LOGIN_ERROR_USER_NOT_FOUND:
                    case LOGIN_ERROR_INVALID_PASSWORD:
                        $result = 'Invalid email and/or password.';
                        break;
                    case LOGIN_ERROR_NOT_ACTIVATED:
                        $result = 'Account not activated.';
                        break;
                } // end switch

            } // end if
        } // end if validation

        // check if the logged in user is an admin
        if (!empty($_user)) {

            if ($_user->is_activated_num == 1) {
                // user is an admin redirect him to the admin pages
                redirect("/admin");
                return;
            } else {
                $result = "'{$_user->full_name_txt}' You are Administrator account is currently inactive!";
            } 

        } else {
            $this->nws_auth->del_s();
        } // end if $_user

        if (empty($result)) $result = validation_errors();

        // error_log('session is success: '.json_encode($this->session->userdata));
        
        $data['result_message'] = $result;
        $this->load_view(array('view' => 'login_view', 'theme' => 'admin', 'template' => 'basic', 'data' => $data));


    } // end of admin auth


    public function logout() {

        $this->nws_auth->logout();

        redirect("/admin");

    } // end function logout
    
    function _check_is_logged_id() {
    
        // check user if already logged in
        if ($this->nws_auth->is_logged_in()) {
            // already logged in
            $id = $this->nws_auth->get_s('id');
            $_user = $this->admin_users_model->get_admin_user_by_id($id);
            // $_user = $this->admin_users_model->get_admin_user_by_id($this->session->userdata('id'));
            if (!empty($_user)) {
                if ($_user->is_activated == 1) {
                    // user is an admin redirect him to the admin pages
                    redirect("/admin");
                } 
            } else {
                $this->nws_auth->del_s();
            }

        } // end if is_logged_in
    }
    
}

