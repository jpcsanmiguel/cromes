<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration extends Base_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index()
	{

		$this->load_view(array(
			'view' => 'registration_view',
			'nav_disable' => FALSE	
			));
	}
}

/* End of file */