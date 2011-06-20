<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Workbench extends Base_Controller {

	function __construct() {
		parent::__construct('fb', FALSE);
	}

	public function index()
	{
		$this->load_view(array('view' => 'workbench_view'));
	}
	
	
}

