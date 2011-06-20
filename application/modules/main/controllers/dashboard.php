<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Base_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index()
	{

		$this->load_view(array(
			'view' => 'dashboard_view',
			'nav_disable' => FALSE	
			));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */