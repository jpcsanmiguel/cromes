<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Base_Controller {

	function __construct() {
		parent::__construct('fb', FALSE);
        $this->load->library('nws_auth');
        $this->load->model('classes_model');
	}

	public function index()
	{
        $this->set_selected_menu('nav-users','nav-users-users');
        
		$this->load_view(array('view' => 'users/view', 'theme' => 'admin'));
	}
    
    public function view(){
    
        $data['users'] = $this->users_model->get_users();
        
        $view = $this->load->view('users/list_view', $data, true);
        
        echo json_encode(array('html' => $view ));
        
    }
    
    public function add(){
        
        $this->load->view('users/add_view');
        
    }
    
    public function process_add(){
    
        $user_id = trim($this->input->post('user_id'));
        $user_tp_id = trim($this->input->post('user_tp_id'));
        $social_api = trim($this->input->post('social_api'));
        $sn_user_id = trim($this->input->post('sn_user_id'));
        $username_txt = trim($this->input->post('username_txt'));
        $gender_txt = trim($this->input->post('gender_txt'));
        $class_txt = trim($this->input->post('class_txt'));
        $email = trim($this->input->post('email'));
        $first_name = trim($this->input->post('first_name'));
        $last_name = trim($this->input->post('last_name'));
        $birthday = trim($this->input->post('birthday'));
        $location = trim($this->input->post('location'));
        $timezone_num = trim($this->input->post('timezone_num'));
        $is_bookmarked = trim($this->input->post('is_bookmarked'));
        $is_fan = trim($this->input->post('is_fan'));
        $is_chat_banned = trim($this->input->post('is_chat_banned'));
        $is_active = trim($this->input->post('is_active'));
        $referred_by = trim($this->input->post('referred_by'));
        $level_num = trim($this->input->post('level_num'));
        $exp_num = trim($this->input->post('exp_num'));
        $exp_max_num = trim($this->input->post('exp_max_num'));
        $ap_num = trim($this->input->post('ap_num'));
        $ap_max_num = trim($this->input->post('ap_max_num'));
        $cash_num = trim($this->input->post('cash_num'));
        $credits_num = trim($this->input->post('credits_num'));
        
        $user_id = "fb_" . $sn_user_id;
        
        $user = $this->users_model->get_user_by_key($user_id, true);
        
        if(count($user) > 0){
            echo json_encode(array('status'=>'not_ok', 'msg'=>'User already exists.'));
            return;
        }
        
        $key = $user_id;
        
        $data = array(
	       'user_id' => $user_id,
	       'user_tp_id' => $user_tp_id,
	       'social_api' => $social_api,
	       'sn_user_id' => $sn_user_id,
	       'username_txt' => $username_txt,
	       'gender_txt' => $gender_txt,
	       'class_txt' => $class_txt,
	       'email' => $email,
	       'first_name' => $first_name,
	       'last_name' => $last_name,
	       'birthday' => $birthday,
	       'birthdate_dt' => date('Y-m-d', strtotime($birthday)),
	       'location' => $location,
	       'timezone_num' => $timezone_num,
	       'is_bookmarked' => $is_bookmarked,
	       'is_fan' => $is_fan,
	       'is_chat_banned' => $is_chat_banned,
	       'is_active' => $is_active,
	       'referred_by' => '',
	       'level_num' => $level_num,
	       'exp_num' => $exp_num,
	       'exp_max_num' => $exp_max_num,
	       'ap_num' => $ap_num,
	       'ap_max_num' => $ap_max_num,
	       'cash_num' => $cash_num,
	       'credits_num' => $credits_num
	    );
	    
	    $this->users_model->new_user($key, $data);
        
        echo json_encode(array('status'=>'ok', 'msg'=>'Class successfully added.'));
        return;
    
    }
    
    public function edit(){
        
        $key = trim($this->input->get('key'));
        
        if(empty($key)){
            echo "  <div class='notification error png_bg'>
                        <div>Invalid Key.</div>
                    </div>";
            return;
        }
        
        $user = $this->users_model->get_user_by_key($key);
        
        if(count($user) <= 0){
            echo "  <div class='notification error png_bg'>
                        <div>User not found.</div>
                    </div>";
            return;
        }
        
        $data['u'] = $user;
        $data['classes'] = $this->classes_model->get_classes();
        
        $this->load->view('users/edit_view', $data);
        
    }
    
    public function process_edit(){
        
        $id = trim($this->input->post('id'));
        
        $username_txt = trim($this->input->post('username_txt'));
        $gender_txt = trim($this->input->post('gender_txt'));
        $class_txt = trim($this->input->post('class_txt'));
        $email = trim($this->input->post('email'));
        $first_name = trim($this->input->post('first_name'));
        $last_name = trim($this->input->post('last_name'));
        $birthday = trim($this->input->post('birthday'));
        $location = trim($this->input->post('location'));
        $timezone_num = trim($this->input->post('timezone_num'));
        $is_bookmarked = trim($this->input->post('is_bookmarked'));
        $sn_profile_picture = trim($this->input->post('sn_profile_picture'));
        $is_fan = trim($this->input->post('is_fan'));
        $is_chat_banned = trim($this->input->post('is_chat_banned'));
        $is_active = trim($this->input->post('is_active'));
        $referred_by = trim($this->input->post('referred_by'));
        $level_num = trim($this->input->post('level_num'));
        $exp_num = trim($this->input->post('exp_num'));
        $exp_max_num = trim($this->input->post('exp_max_num'));
        $ap_num = trim($this->input->post('ap_num'));
        $ap_max_num = trim($this->input->post('ap_max_num'));
        $cash_num = trim($this->input->post('cash_num'));
        $credits_num = trim($this->input->post('credits_num'));
        
        $user = $this->users_model->get_user_by_key($id);
        
        if(count($user) <= 0){
            echo json_encode(array('status'=>'not_ok', 'msg'=>'User not found.'));
            return;
        }
        
        $data = get_object_vars($user);
        
        $key = $data['id'];
        
        $data['username_txt'] = $username_txt;
        $data['gender_txt'] = $gender_txt;
        $data['class_txt'] = $class_txt;
        $data['email'] = $email;
        $data['first_name'] = $first_name;
        $data['last_name'] = $last_name;
        $data['birthday'] = $birthday;
        $data['birthdate_dt'] = date('Y-m-d', strtotime($birthday));
        $data['location'] = $location;
        $data['timezone_num'] = $timezone_num;
        $data['is_bookmarked'] = $is_bookmarked;
        $data['sn_profile_picture'] = $sn_profile_picture;
        $data['is_fan'] = $is_fan;
        $data['is_chat_banned'] = $is_chat_banned;
        $data['is_active'] = $is_active;
        $data['referred_by'] = '';
        $data['level_num'] = $level_num;
        $data['exp_num'] = $exp_num;
        $data['exp_max_num'] = $exp_max_num;
        $data['ap_num'] = $ap_num;
        $data['ap_max_num'] = $ap_max_num;
        $data['cash_num'] = $cash_num;
        $data['credits_num'] = $credits_num;
        
        $this->users_model->update_user($key, $data);
        
        echo json_encode(array('status'=>'ok', 'msg'=>'User successfully edited.'));
        return;
    
    }
    
    public function delete(){
        
        $key = trim($this->input->get('key'));
        
        if(empty($key)){
            echo "  <div class='notification error png_bg'>
                        <div>Invalid Key.</div>
                    </div>";
            return;
        }
        
        $user = $this->users_model->get_user_by_key($key);
        
        if(count($user) <= 0){
            echo "  <div class='notification error png_bg'>
                        <div>User not found.</div>
                    </div>";
            return;
        }
        
        $data['u'] = $user;
        
        $this->load->view('users/delete_view', $data);
        
    }
    
    public function process_delete(){
        
        $id = trim($this->input->post('id'));
        
        $user = $this->users_model->get_user_by_key($id);
        
        if(count($user) <= 0){
            echo json_encode(array('status'=>'not_ok', 'msg'=>'User not found.'));
            return;
        }
        
        $this->users_model->delete_user($id);
        
        echo json_encode(array('status'=>'ok', 'msg'=>'User successfully deleted.'));
        return;
    
    }
    
}

