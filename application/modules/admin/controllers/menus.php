<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menus extends Base_Controller {

	function __construct() {
		parent::__construct('fb', FALSE);
        $this->load->library('nws_auth');
	}

	public function index()
	{
        $this->set_selected_menu('nav-admin','nav-admin-menus');
        $this->load_view(array('view' => 'menus/view', 'theme' => 'admin'));
	
	}
    
    public function main_menus(){
    
        $data['menus'] = $this->admin_nav_menu_model->get_nav_menus("parent_id:main");
        
        $view = $this->load->view('menus/main_list_view', $data, true);
        
        echo json_encode(array('html' => $view ));
        
    }
    
    public function sub_menus(){
        
        $parent_id = $this->input->post('parent_id');
    
        $data['parent_menu'] = $this->admin_nav_menu_model->get_nav_menu_by_id($parent_id);
        $data['menus'] = $this->admin_nav_menu_model->get_nav_menus("parent_id:".$parent_id);
        
        $view = $this->load->view('menus/sub_list_view', $data, true);
        
        echo json_encode(array('html' => $view ));
        
    }
    
    public function add(){
        
        $parent_id = $this->input->get('parent_id');
        
        if(empty($parent_id)) $parent_id = "main";
        
        $data['parent_id'] = $parent_id;
        
        $this->load->view('menus/add_view',$data);
        
    }
    
    public function edit(){
        
        $id = $this->input->get('id');
        
        $data['menu'] = $this->admin_nav_menu_model->get_nav_menu_by_id($id);
        
        $this->load->view('menus/edit_view',$data);
        
    }
    
    public function delete(){
        
        $id = $this->input->get('id');
        
        $data['menu'] = $this->admin_nav_menu_model->get_nav_menu_by_id($id);
        
        $this->load->view('menus/delete_view',$data);
        
    }
    
    public function process_add(){
        
        $title = $this->input->post('title');
        $elem_id = $this->input->post('elem_id');
        $url = $this->input->post('url');
        $parent_id = $this->input->post('parent_id');
        
        $menu = $this->admin_nav_menu_model->get_nav_menu_by_id($elem_id, true);
        
        if(count($menu) > 0){
            echo json_encode(array('status'=>'not_ok', 'msg'=>'Element ID already in use.'));
            return;
        }
        
        $key = $elem_id;
        
        $data = array(
            'title_txt' => $title,
            'elem_id' => $elem_id,
            'url_txt' => $url,
            'parent_id' => $parent_id
        );
        
        $this->admin_nav_menu_model->new_nav_menu($key, $data);
        
        echo json_encode(array('status'=>'ok', 'msg'=>'Menu successfully added.'));
        return;
        
    }
    
    public function process_edit(){
        
        $id = trim($this->input->post('id'));
        $title = $this->input->post('title');
        $url = $this->input->post('url');
        
        $menu = $this->admin_nav_menu_model->get_nav_menu_by_id($id);
        
        $data = get_object_vars($menu);
        
        $key = $data['id'];
        
        $data['title_txt'] = $title;
        $data['url_txt'] = $url;
        
        $this->admin_nav_menu_model->update_nav_menu($key, $data);
        
        echo json_encode(array('status'=>'ok', 'msg'=>'Menu successfully edited.'));
        return;
    
    }
    
    public function process_delete(){
    
        $id = trim($this->input->post('id'));
        
        $sub_menus = $this->admin_nav_menu_model->get_nav_menus("parent_id:".$id);
        if(count($sub_menus) > 0){ // delete sub-menu
            foreach($sub_menus as $sm){
                $this->admin_nav_menu_model->delete_nav_menu($sm->id);
            }
        }
        
        $this->admin_nav_menu_model->delete_nav_menu($id);
        
        echo json_encode(array('status'=>'ok', 'msg'=>'Menu successfully deleted.'));
        return;
        
    }
    
	
}

