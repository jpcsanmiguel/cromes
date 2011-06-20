<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admins extends Base_Controller {

	function __construct() {
		parent::__construct('fb', FALSE);
        $this->load->library('nws_auth');
	}

	public function index()
	{
        $this->set_selected_menu('nav-admin','nav-admin-admins');
        
		$this->load_view(array('view' => 'admins/view', 'theme' => 'admin'));
	}
    
    public function view(){
    
        $data['admin_users'] = $this->admin_users_model->get_admin_users();
        
        $view = $this->load->view('admins/list_view', $data, true);
        
        echo json_encode(array('html' => $view ));
        
    }
    
    public function add(){
        
        $this->load->view('admins/add_view');
        
    }
    
    public function process_add(){
    
        $full_name = trim($this->input->post('full_name'));
        $email = trim($this->input->post('email'));
        $password = trim($this->input->post('password'));
        $is_activated = abs($this->input->post('is_activated'));
        $role_id = abs($this->input->post('role_id'));
        
        $admin = $this->admin_users_model->get_admin_user_by_id($email, true);
        
        $key = $email;
        
        if(count($admin) > 0){
            echo json_encode(array('status'=>'not_ok', 'msg'=>'Email already exists.'));
            return;
        }
        
        $password = md5($password);
        
        $data = array(
            'email_txt' => $email,
            'full_name_txt' => $full_name,
            'password_txt' => $password,
            'role_id_num' => $role_id,
            'is_activated_num' => $is_activated
        );
        
        $this->admin_users_model->new_admin_user($key, $data);
        
        echo json_encode(array('status'=>'ok', 'msg'=>'Admin successfully added.'));
        return;
    
    }
    
    public function edit(){
        
        $key = trim($this->input->get('key'));
        
        if(empty($key)){
            // echo json_encode(array('status'=>'not_ok', 'msg'=>'Invalid Key.'));
            echo "  <div class='notification error png_bg'>
                        <div>Invalid Key.</div>
                    </div>";
            return;
        }
        
        $admin_user = $this->admin_users_model->get_admin_user_by_id($key);
        
        if(count($admin_user) <= 0){
            // echo json_encode(array('status'=>'not_ok', 'msg'=>'User not found.'));
            echo "  <div class='notification error png_bg'>
                        <div>User not found.</div>
                    </div>";
            return;
        }
        
        $data['u'] = $admin_user;
        
        $this->load->view('admins/edit_view', $data);
        
    }
    
    public function process_edit(){
        
        $id = trim($this->input->post('id'));
        $full_name = trim($this->input->post('full_name'));
        $role_id = abs($this->input->post('role_id'));
        $is_activated = abs($this->input->post('is_activated'));
        
        
        $admin = $this->admin_users_model->get_admin_user_by_id($id);
        
        $data = get_object_vars($admin);
        
        $key = $data['id'];
        
        $data['full_name_txt'] = $full_name;
        $data['role_id_num'] = $role_id;
        $data['is_activated_num'] = $is_activated;
        
        $this->admin_users_model->update_admin_user($key, $data);
        
        echo json_encode(array('status'=>'ok', 'msg'=>'Admin successfully edited.'));
        return;
    
    }
    
    public function delete(){
        
        $key = trim($this->input->get('key'));
        
        if(empty($key)){
            // echo json_encode(array('status'=>'not_ok', 'msg'=>'Invalid Key.'));
            echo "  <div class='notification error png_bg'>
                        <div>Invalid Key.</div>
                    </div>";
            return;
        }
        
        $admin_user = $this->admin_users_model->get_admin_user_by_id($key);
        
        if(count($admin_user) <= 0){
            // echo json_encode(array('status'=>'not_ok', 'msg'=>'User not found.'));
            echo "  <div class='notification error png_bg'>
                        <div>User not found.</div>
                    </div>";
            return;
        }
        
        $data['u'] = $admin_user;
        
        $this->load->view('admins/delete_view', $data);
        
    }
    
    public function process_delete(){
        
        $id = trim($this->input->post('id'));
        
        $this->admin_users_model->delete_admin_user($id);
        
        echo json_encode(array('status'=>'ok', 'msg'=>'Admin successfully deleted.'));
        return;
    
    }
    
}

