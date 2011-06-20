<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @Author : oam
 * @Date   : 2009-05-18
 */
 
// NOTE: Constants are declared in the config/constants.php

class NWS_Auth {
  
    var $ci = null;
    var $user = null;
  
    /*
    * CONSTRUCTOR
    */
    function __construct() {
        
        $this->ci =& get_instance();
        
        // load the admin users model
        $this->ci->load->model('admin_users_model');
        $this->ci->load->model('admin_nav_menu_model');
        
        if($this->is_logged_in()){
            // $user_id = $this->ci->session->userdata('id');
            $user_id = $this->get_s('id');
            $this->user = $this->ci->admin_users_model->get_admin_user_by_id($user_id);
        }else{
            
            if(!strpos(current_url(),"admin/auth")){
                
                redirect(base_url()."admin/auth");
            
            }
        
        }

    }
  
  /*
   * Login authentication function
   */
  function login($username, $password, $remember = FALSE) {

    // cast variables
    $username = (string) $username;
    $passowrd = (string) $password;

    $user = $this->ci->admin_users_model->get_admin_user_by_id($username, true);
    
    if (!is_null($user)) {
      // user exist
      
      // check user's password
      if ($user->password_txt == md5($password)) {
        // valid password
        
        // construct the data for the session
        $data = array(
              'id' => $user->id,
              'email' => $user->email_txt,
              'status' => ($user->is_activated_num == 1) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED,
            );

        // $this->ci->session->set_userdata('admin_user',$data);
        $this->set_s($data);

        if ($remember) {
          $cookie_name = $this->ci->config->item('cookie_prefix') . $this->ci->config->item('sess_cookie_name');
          $cookie_values = get_cookie($cookie_name);

          delete_cookie($cookie_name);

          $cookie = array(
                   'name'   => $this->ci->config->item('sess_cookie_name'),
                   'value'  => $cookie_values,
                   'expire' => '31968000',  // one year
                   'domain' => $this->ci->config->item('cookie_domain'),
                   'path'   => $this->ci->config->item('cookie_path'),
                   'prefix' => $this->ci->config->item('cookie_prefix'),
               );

          set_cookie($cookie);
        } // end if remember
        
        
        if ($user->is_activated_num == 0) {
          // user not yet activated
          // TODO: not activated processing
          
          return LOGIN_ERROR_NOT_ACTIVATED;
          
        } else {
          // user is activated
          // TODO: extra login ok processing
          
          return LOGIN_OK;
        }
        
      } else {
        // invalid password
        // TODO: extra invalid password processing
        
        return LOGIN_ERROR_INVALID_PASSWORD;
      }
      
    } else {
      // user not found
      // TODO: extra user not found processing
      
      return LOGIN_ERROR_USER_NOT_FOUND;
    }// end if 
    
    return LOGIN_ERROR_INVALID_REQUEST;
    
  } // end function login
  
  /*
   * Logout function
   */
  function logout() {
    
    $this->del_s();


  } // end function logout
  
  /*
   * is login function
   */
  function is_logged_in($activated = TRUE) {
    // $status = $this->ci->session->userdata('status');
    $status = $this->get_s('status');
    if (empty($status)) 
      return false;

      return $status == ($activated ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED);
  } // end function is_logged_in
    
    // session handling
    function get_s($key){
        $admin_user = $this->ci->session->userdata('admin_user');
        return $admin_user[$key];
    }
    
    function set_s($data){
        $this->ci->session->set_userdata('admin_user',$data);
    }
    
    function del_s(){
        $this->ci->session->unset_userdata('admin_user');
    }
    
} // end of NWS_Auth


// end of php script