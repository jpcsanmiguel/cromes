<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Base Controller
 */
class Base_Controller extends CI_Controller {

    public $breadcrumbs = array();
    public $header_scripts = array();
    public $footer_scripts = array();

    public $selected_menu = 'nav-dashboard';
    public $selected_sub_menu = '';

    public $theme = "basic";
	public $skin = "default";
	
	public $urls = null;

	public $lang_code = 'en';
	public $is_ajax = FALSE;
	
	// active user
	public $user = NULL;

	// sub=domian
	public $subdomain = "";
	
	// SOCIAL NETWORK OBJECT
	public $sn = null;

	function __construct() {
        parent::__construct();

        // get sub domain
        if ($this->config->item('core_domain') != strtolower($_SERVER['HTTP_HOST'])) {
        	$_subdomains = explode('.', $_SERVER['HTTP_HOST'], 2);
        	$this->subdomain = $_subdomains[0];
    	}
		
		$this->output->set_header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT');
		
		// initialize urls
		$this->urls = new ArrayClass(array(
						'base_url' 			=> $this->config->item('base_url'),
						'js_base_url' 		=> $this->config->item('js_base_url'),
						'css_base_url' 		=> $this->config->item('css_base_url'),
						'assets_base_url' 	=> $this->config->item('assets_base_url'),
						'return_url' 		=> '',
						'chat_server_url' 	=> $this->config->item('chat_server_url')
						));

		if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) 
            $this->is_ajax = $_SERVER['HTTP_X_REQUESTED_WITH'] == 'GBSReqClientRequest';
		
		// set language if its set
		$this->lang_code = isset($_REQUEST['lang'])? $_REQUEST['lang'] : 'en';
		
    }
	
	/**
	 * Set the new language to be used
	 *
	 * @param string $lang
	 */
	function set_language($lang = "en") {
		$_languages = $this->config->item('lang');
        if (!array_key_exists($lang, $_languages)) $lang = "en";
        $language = $_languages[$lang];
        $this->config->set_item('language', $language);
	}
	
	/**
	 * Reload the currently loaded language files
	 *
	 */
	function reload_language() {
	
	}
	
	
	/**
	 * Load the view inside the themed template
	 *
	 * @param array $params
	 */
	function load_view($params = array()) {
	
		if (!array_key_exists('template', $params)) $params['template'] = 'main';
		if (!array_key_exists('title', $params)) $params['title'] = '';
		if (!array_key_exists('data', $params)) $params['data'] = NULL;
		if (!array_key_exists('view', $params)) $params['view'] = '';
		if (!array_key_exists('nav_disable', $params)) $params['nav_disable'] = FALSE;
		if (!array_key_exists('theme', $params)) $params['theme'] = NULL;
		
		$params['owner'] = $this;
		
		$theme = $this->theme;
		if ($params['theme'] != NULL) $theme = $params['theme'];
		
		$path = "../../themes/{$theme}/{$params['template']}.php";

        $this->load->view($path, $params);
	
	}
	
	
	/**
	 * Add breadcrumbs to be used in the page header
	 *
	 * @param string $title
	 * @param string $link
	 * @param bool $active
	 */
	function add_breadcrumbs($title, $link = '#', $active = TRUE) {
        $this->breadcrumbs[] = array('title' => $title, 'link' => $link, 'active' => $active);
    } 

	/**
	 * Clear the current defined/assed breadcrumbs
	 *
	 */
    function clear_breadcrumbs() {
        unset($this->breadcrumbs);
        $this->breadcrumbs = array();
    } 

	/**
	 * Add a script at the header part of the page
	 *
	 * @param string $type
	 * @param string $url
	 */
    function add_header_scripts($type, $url) {
        $this->header_scripts[] = array('type' => $type, 'url' => $url);
    }

	/**
	 * Add a script at the footer part of the page
	 *
	 * @param string $type
	 * @param string $url
	 */
    function add_footer_scripts($type, $url) {
        $this->footer_scripts[] = array('type' => $type, 'url' => $url);
    }

	/**
	 * Set the selected menu
	 *
	 * @param string $menu_element_id
	 * @param string $sub_menu_element_id
	 */
    function set_selected_menu($menu_element_id, $sub_menu_element_id) {
        $this->selected_menu = $menu_element_id;
        $this->selected_sub_menu = $sub_menu_element_id;
    }
    
    /**
     * override redirect
     */
    function redirect($uri) {
        $uri .= "?" . http_build_query($_REQUEST);
        //error_log($uri);
        redirect($uri);
    }

}

