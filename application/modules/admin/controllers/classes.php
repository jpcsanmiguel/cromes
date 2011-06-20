<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Classes extends Base_Controller {

	function __construct() {
		parent::__construct('fb', FALSE);
        $this->load->library('nws_auth');
        $this->load->model('classes_model');
	}

	public function index()
	{
        $this->set_selected_menu('nav-ref','nav-ref-classes');
        
		$this->load_view(array('view' => 'classes/view', 'theme' => 'admin'));
	}
    
    public function view(){
    
        $data['classes'] = $this->classes_model->get_classes();
        
        $view = $this->load->view('classes/list_view', $data, true);
        
        echo json_encode(array('html' => $view ));
        
    }
    
    public function add(){
        
        $this->load->view('classes/add_view');
        
    }
    
    public function process_add(){
    
        $code = trim($this->input->post('code'));
        $name = trim($this->input->post('name'));
        $description = trim($this->input->post('description'));
        
        $class = $this->classes_model->get_class_by_id($code, true);
        
        if(count($class) > 0){
            echo json_encode(array('status'=>'not_ok', 'msg'=>'Code already in use.'));
            return;
        }
        
        $key = $code;
        
        $data = array(
            'code' => $code,
            'name' => $name,
            'description' => $description
        );
        
        $this->classes_model->new_class($key, $data);
        
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
        
        $class = $this->classes_model->get_class_by_id($key);
        
        if(count($class) <= 0){
            echo "  <div class='notification error png_bg'>
                        <div>User not found.</div>
                    </div>";
            return;
        }
        
        $data['c'] = $class;
        
        $this->load->view('classes/edit_view', $data);
        
    }
    
    public function process_edit(){
        
        $id = trim($this->input->post('id'));
        $name = trim($this->input->post('name'));
        $description = trim($this->input->post('description'));
        
        $class = $this->classes_model->get_class_by_id($id);
        
        $data = get_object_vars($class);
        
        $key = $data['id'];
        
        $data['name'] = $name;
        $data['description'] = $description;
        
        $this->classes_model->update_class($key, $data);
        
        echo json_encode(array('status'=>'ok', 'msg'=>'Class successfully edited.'));
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
        
        $class = $this->classes_model->get_class_by_id($key);
        
        if(count($class) <= 0){
            echo "  <div class='notification error png_bg'>
                        <div>User not found.</div>
                    </div>";
            return;
        }
        
        $data['c'] = $class;
        
        $this->load->view('classes/delete_view', $data);
        
    }
    
    public function process_delete(){
        
        $id = trim($this->input->post('id'));
        
        $this->classes_model->delete_class($id);
        
        echo json_encode(array('status'=>'ok', 'msg'=>'Class successfully deleted.'));
        return;
    
    }
    
}

