<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Base_Controller {

	function __construct() {
		parent::__construct('fb', FALSE);
        $this->load->library('nws_auth');
	}

	public function index()
	{
        $this->set_selected_menu('nav-dashboard','');
        $this->load_view(array('view' => 'dashboard_view', 'theme' => 'admin'));
	
	}
    
    public function test()
    {
    
        $this->load_view(array('view' => 'test_view', 'theme' => 'admin'));
    }
	
}

