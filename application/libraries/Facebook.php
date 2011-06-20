<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/* load the facebook api class */
//require APPPATH."third_party/facebook.php";
include_once APPPATH."libraries/ArrayClass.php";

/*
 */
class facebookConnection {
		
	// Allow multi-threading.
	
	private $_mch = NULL;
	private $_properties = array();
	
	function __construct()
	{
		$this->_mch = curl_multi_init();
		
		$this->_properties = array(
			'code' 		=> CURLINFO_HTTP_CODE,
			'time' 		=> CURLINFO_TOTAL_TIME,
			'length'	=> CURLINFO_CONTENT_LENGTH_DOWNLOAD,
			'type' 		=> CURLINFO_CONTENT_TYPE
		);
	}
	
	private function _initConnection($url)
	{
		$this->_ch = curl_init($url);
		curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, TRUE);
	}
	
	public function get($url, $params = array())
	{
		if ( count($params) > 0 )
		{
			$url .= '?';
		
			foreach( $params as $k => $v )
			{
				$url .= "{$k}={$v}&";
			}
			
			$url = substr($url, 0, -1);
		}
		
		$this->_initConnection($url);
		$response = $this->_addCurl($url, $params);

		return $response;
	}
	
	public function post($url, $params = array())
	{
		// Todo
		$post = '';
		
		foreach ( $params as $k => $v )
		{
			$post .= "{$k}={$v}&";
		}
		
		$post = substr($post, 0, -1);
		
		$this->_initConnection($url, $params);
		curl_setopt($this->_ch, CURLOPT_POST, 1);
		curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $post);
		
		$response = $this->_addCurl($url, $params);

		return $response;
	}
	
	private function _addCurl($url, $params = array())
	{
		$ch = $this->_ch;
		
		$key = (string) $ch;
		$this->_requests[$key] = $ch;
		
		$response = curl_multi_add_handle($this->_mch, $ch);

		if ( $response === CURLM_OK || $response === CURLM_CALL_MULTI_PERFORM )
		{
			do {
				$mch = curl_multi_exec($this->_mch, $active);
			} while ( $mch === CURLM_CALL_MULTI_PERFORM );
			
			return $this->_getResponse($key);
		}
		else
		{
			return $response;
		}
	}
	
	private function _getResponse($key = NULL)
	{
		if ( $key == NULL ) return FALSE;
		
		if ( isset($this->_responses[$key]) )
		{
			return $this->_responses[$key];
		}
		
		$running = NULL;
		
		do
		{
			$response = curl_multi_exec($this->_mch, $running_curl);
			
			if ( $running !== NULL && $running_curl != $running )
			{
				$this->_setResponse($key);
				
				if ( isset($this->_responses[$key]) )
				{
					$response = new facebookResponse( new ArrayClass($this->_responses[$key]) );

					if ( $response->header->code !== 200 )
					{
						$error = $response->header->code.' | Request Failed';
						
						if ( isset($response->data->error->type) )
						{
							$error .= ' - '.$response->data->error->type.' - '.$response->data->error->message;
						}
						
						throw new facebookException($error);
					}
					
					return (object)$response;
				}
			}
			
			$running = $running_curl;
			
		} while ( $running_curl > 0);
		
	}
	
	private function _setResponse($key)
	{
		while( $done = curl_multi_info_read($this->_mch) )
		{
			$key = (string) $done['handle'];
			$this->_responses[$key]['data'] = curl_multi_getcontent($done['handle']);
			
			foreach ( $this->_properties as $curl_key => $value )
			{
				$this->_responses[$key][$curl_key] = curl_getinfo($done['handle'], $value);
				
				curl_multi_remove_handle($this->_mch, $done['handle']);
			}
	  }
	}
}

class facebookResponse {
	
	private $__construct;

	public function __construct($resp)
	{
		$this->data = $resp->data;
		$this->header = new ArrayClass(array(
		    'code' => $resp->code,
    		'time' => $resp->time,
    		'length' => $resp->length,
    		'type' => $resp->type
		));
		
		$data = json_decode($resp->data);
		if ( $data !== NULL ) $this->data = $data;
		
	}

	public function __get($name)
	{
	    if ($name === 'header') return $this->header;
	    
		if ($this->header->code < 200 || $this->header->code > 299) return FALSE;

		$result = array();

		if ( is_string($this->data ) )
		{
			parse_str($this->data, $result);
			$this->data = new ArrayClass($result);
		}
		
		if ($name === 'data') return $this->data;
		
		if (isset($this->data->$name)) return $this->data->$name;
		
		return FALSE;
	}
}

class facebookException extends Exception {
	
	function __construct($string)
	{
		parent::__construct($string);
	}
	
	public function __toString() {
		return "exception '".__CLASS__ ."' with message '".$this->getMessage()."' in ".$this->getFile().":".$this->getLine()."\nStack trace:\n".$this->getTraceAsString();
	}
}
 

/*
 *
 */
class Facebook {

	public $app_id = "";
    public $api_key = "";
    public $app_secret = "";
    public $base_domain = "";
    public $fb_base_url = "";
	public $is_canvas = FALSE;

    public $lib = null;
    
    public $session = null;
    public $signed_request = null;
    public $access_token = '';
    public $login_url = '';

    public $uid = '0';
    public $user = null;
	public $token = "";
    
    public $redirect_url = "";
	
	private $_graph_url = "https://graph.facebook.com/";
	private $_api_url = "https://api.facebook.com/";
	private $_token_url = "oauth/access_token";
	private $_auth_url = "";
	private $_request = NULL;
	private $_signed_request = "";
	
	
	private $_obj = NULL;

	function __construct($params) {
	
		$this->_obj =& get_instance();
		
		$this->app_id = $params['app_id'];
        $this->api_key = $params['api_key'];
        $this->app_secret = $params['app_secret'];
        $this->base_domain = $params['base_domain'];
		$this->base_url = $params['base_url'];
        $this->fb_base_url = $params['fb_base_url'];
		$this->is_canvas = $params['is_canvas'];
		
		$this->_token_url = $this->_graph_url . $this->_token_url;
		$this->_auth_url = "http://www.facebook.com/dialog/oauth?client_id=" . $this->app_id;
		
		// Prevent the 'Undefined index: facebook_config' notice from being thrown.
        $GLOBALS['facebook_config']['debug'] = NULL;
		
		if (isset($_REQUEST['signed_request'])) {
			$this->_signed_request = $_REQUEST['signed_request'];
			$this->_request = parse_signed_request($this->_signed_request, $this->app_secret);
            if (isset($this->_request['user_id'])) $this->uid = $this->_request['user_id'];
            $this->token = $this->_get_token_from_signed_request();
            $this->_set('token', $this->token);
		}
		
		$this->connection = new facebookConnection();
		
		/*
		$this->lib = new FbLib(array(
                          'appId'  => $this->app_id,
                          'secret' => $this->app_secret,
                          'domain' => $this->base_domain,
                          'cookie' => TRUE
                        ));
		*/
	}
	
	/*
	 * RETURN THE SIGNED REQUEST PASSED BY FB
	 */
	public function get_signed_request() {
		return $this->_signed_request;
	}
	
	public function get_request() {
		return $this->_request;
	}
	
	/*
	 * Authenticate the current user session using the signed_request 
	 */
	public function canvas_auth() {
	
		// force the canvas
		$this->is_canvas = TRUE;
	
		if (NULL === $this->_request) {
			// not authenicated
			$this->redirect_to_login();
		}

		if (!isset($this->_request['user_id'])) {
			// not authenicated
			$this->redirect_to_login();
			
		}
		
		$this->uid = $this->_request['user_id'];
		
		// retrive data from session
		$this->token = $this->_get('token');
		$this->user = $this->_get('user');

	}
	
	public function get_auth_path() {
		if ($this->is_canvas) {
			return $this->fb_base_url . "auth";
		} else {
			return $this->base_url . "fb/auth";
		}
	}
	
	public function redirect_to_login($scope = "email,publish_stream") {
		$this->clear();
		$_state = md5(uniqid(rand(), TRUE));
		$this->_set('state', $_state);
		redirect_top($this->_auth_url . "&state=" . $_state . "&scope=" . $scope . "&redirect_uri=" . urlencode($this->get_auth_path()));
	}
	
	public function get_state() {
		return $this->_get('state');
	}
	
	public function clear_state() {
		$this->_unset('state');
	}
	
	
	public function clear() {
		$this->_unset('token');
		$this->_unset('user');
	}
	
	private function _get_token_from_signed_request() {
	
		$token = NULL;
	
		if (isset($this->_request['oauth_token'])) {
			$token = new ArrayClass(array(
							'access_token' => $this->_request['oauth_token'],
							'expires' => $this->_request['expires']
						));
						
			return $token;
		}
		
		return NULL;
	
	}
	
	
	public function get_token($code) {
	
		// check if signed request present
		$this->token = $this->_get_token_from_signed_request();
	
		if (NULL === $this->token)  $this->token = $this->_get('token');
			
		if ( !empty($this->token) )
		{
			if ( !empty($this->token->expires) && intval($this->token->expires) >= time() )
			{
				// Problem, token is expired!
				$this->clear();
			} else {
				$this->_set('token', $this->token);
				return $this->_token_string();
			}
			
		}
	
		$token_url = $token_url = $this->_token_url.'?client_id='.$this->app_id."&client_secret=".$this->app_secret."&code=".$code.'&redirect_uri='.urlencode($this->get_auth_path());
		
		try {
			$token = $this->connection->get($token_url);
			
			$this->token = new ArrayClass(array(
								'access_token' => $token->access_token,
								'expires' => $token->expires
							));
			
		} catch (facebookException $e) {
			$this->clear();
			return NULL;
		}
		
		if ( $this->token->access_token ) {
		
			if ( !empty($this->token->expires) ) {
				$this->token->expires = strval(time() + intval($this->token->expires));
			}
			
			$this->_set('token', $this->token);
		}

		return $this->token;
	
	}
	
	public function get_user($from_cache = true, $fields = "third_party_id,username,email,name,first_name,last_name,link,gender,birthday,hometown,location,locale,timezone,updated_time,verified") {
	
	    if (!empty($fields)) $fields = "fields=".$fields;
	    
	    if ($from_cache) {
		    $this->user = $this->_get('user');

    		if ( !empty($this->user) ) {
    		    $this->uid = $this->user->uid;
    		    $this->_set('user', $this->user);
    		    return $this->user;
    	    }
        }
	    
		
		$user_url = $this->_graph_url . "me?" . $fields . "&". $this->_token_string();
		
		try {
			$this->user = $this->connection->get($user_url);
		} catch (Exception $e) {
			$this->clear();
			return NULL;
		}
		
		$this->_set('user', $this->user);
		return $this->user;
		
	}
	
	public function get_user_friends($params = array()) {
	    $path = "me/friends?";
	    
	    $filter = "";
	    
	    if (isset($params['offset'])) { 
	        if ($params['offset'] < 0) $params['offset'] = 0;
	        $filter .= "offset=" . $params['offset'] . "&";
        }
        
	    if (isset($params['limit'])) {
	        if ($params['limit'] < 1) $params['limit'] = 1;
	        $filter .= "limit=" . $params['limit'] . "&";
        }
	    
	    $request_url = $this->_graph_url . "me/friends?" . $filter . $this->_token_string();
	    
	    $result = array();
	    
	    try {
			$ret = $this->connection->get($request_url);
			$result = $ret;
		} catch (Exception $e) {
			return NULL;
		}
	    
	    return $result;
	    
	}
	
	public function get_user_friend_app_users() {
	    
	    $request_url = $this->_api_url . "method/friends.getAppUsers?format=json&" . $this->_token_string();
	    
	    $result = array();
	    
	    try {
			$ret = $this->connection->get($request_url);
			if ($ret != null) {
			    // expected result will be float values, this is due the returned value from facebook, and json_decode treats it as numeric float value.
			    // so covert float value to string without the floating points
			    foreach ($ret->data as $value)
			        $result[] = sprintf("%.0f", $value);
			} else 
			$result = new ArrayClass($ret->data);
		} catch (Exception $e) {
			return NULL;
		}
		
	    return $result;
	    
	}
	
	private function _get($key)
	{
		$key = '_facebook_'.$key;
		return $this->_obj->session->userdata($key);
	}
	
	private function _set($key, $data)
	{
		$key = '_facebook_'.$key;
		$this->_obj->session->set_userdata($key, $data);
	}
	
	private function _unset($key)
	{
		$key = '_facebook_'.$key;
		$this->_obj->session->unset_userdata($key);
	}
	
	private function _token_string()
	{
		return 'access_token='.$this->_get('token')->access_token;
	}
	
	public function append_token($url)
	{
		if ( $this->_get('token') ) $url .= '?'.$this->_token_string();
		
		return $url;
	}
	
	
}



