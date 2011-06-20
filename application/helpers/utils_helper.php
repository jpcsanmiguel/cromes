<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( !function_exists('facebook_xmlns')){
	function facebook_xmlns()
	{
		return 'xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/"';
	}
}

if ( ! function_exists('text_replace')){

    function text_replace($source, $params) {
        
        $result = $source;
        
        foreach ($params as $key => $value) {
            
            $result = str_replace($key, $value, $result);
        }
        
        return $result;
    }

} // end if


if ( ! function_exists('hash_hmac')) {

    function hash_hmac($algo='md5', $message, $secret_key) {
        $block_size_md5 = 64; // md5 block size is 64 bytes = 512 bits
        $opad = str_pad('', $block_size_md5, chr(0x5c));
        $ipad = str_pad('', $block_size_md5, chr(0x36));
        if (strlen($secret_key) > $block_size_md5) {
            $secret_key = md5($secret_key, true /*raw binary*/); // $secret_key is now 16 bytes long
        }

        $secret_key = str_pad($secret_key, $block_size_md5, chr(0x00));

        $ipad = $secret_key ^ $ipad; 

        $opad = $secret_key ^ $opad;

        return md5($opad . md5($ipad . $message, true /*raw binary*/));
    } 
}

/* returns a result from a url */
if (!function_exists('get_url')) {
	function get_url($url, $params) {
	
		$content = "";
		foreach ($params as $key => $param) {
			$content .= "{$key}=" . urlencode($param) . "&";
		}
		substr($content, 0, strlen($content) - 1);

		$user_agent = 'NWS-1.0' . phpversion();
		$content_type = 'application/x-www-form-urlencoded';
		
		$content_length = strlen($content);
		$context =
		  array('http' =>
				  array('method' => 'POST',
						'user_agent' => $user_agent,
						'header' => 'Content-Type: ' . $content_type . "\r\n" .
									'Content-Length: ' . $content_length,
						'content' => $content));
		$context_id = stream_context_create($context);
		ini_set ('user_agent', $user_agent); 
		$sock = fopen($url, 'r', false, $context_id);

		$result = '';
		if ($sock) {
		  while (!feof($sock)) {
			$result .= fgets($sock, 4096);
		  }
		  fclose($sock);
		}
		
		return $result;
	
	}
}

/* format string to key */
if (!function_exists('to_key')) {
    function to_key($value) {
        $_value = str_replace(" ", "_", strtolower(trim($value)));
        return $_value;
    }
}

/* get language */
if (!function_exists('get_lang')) {
    function get_lang() {
        $arg_list = func_get_args();
        $arg_count = count($arg_list);
        $lang_key = $arg_list[0]; // lang key
        $_value = lang($lang_key);
        for ($i = 1; $i < $arg_count; $i++) {
            $_value = str_replace("%value".$i."%", $arg_list[$i], $_value);
        }
        return $_value;
    }
}

if (!function_exists('parse_signed_request')) {
	function parse_signed_request($signed_request, $secret) {
		list($encoded_sig, $payload) = explode('.', $signed_request, 2);

		  // decode the data
		  $sig = base64_url_decode($encoded_sig);
		  $data = json_decode(base64_url_decode($payload), true);

		  if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
			  error_log('Unknown algorithm. Expected HMAC-SHA256');
			  return NULL;
		  }

		  // check signature
		  $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
		  if ($sig !== $expected_sig) {
			  error_log('Bad Signed JSON signature!');
			  return NULL;
		  }

		  return $data;
	}
}

if (!function_exists('base64_url_decode')) {
	function base64_url_decode($input) {
		return base64_decode(strtr($input, '-_', '+/'));
	}
}

if (!function_exists('redirect_top')) {
	function redirect_top($url) {
		echo("<script> top.location.href='" . $url . "'</script>");
		exit(0);
	}
}

if (!function_exists('url_strip_query')) {
	function url_strip_query($url = NULL)
	{
		if ( $url === NULL )
		{
			$url = ( empty($_SERVER['HTTPS']) ) ? 'http' : 'https';
			$url .= '://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}
		
		$parts = explode('?', $url);
		return $parts[0];
	}
}


if (!function_exists('fixObject')) {
	function fixObject (&$object)
	{
	  if (!is_object ($object) && gettype ($object) == 'object')
		return ($object = unserialize (serialize ($object)));
	  return $object;
	}
}

if ( ! function_exists('admin_pagination_create')){

  //function to return the pagination string for admin
    function admin_pagination_create($element_id = '', $page = 1, $totalitems, $limit = 15, $adjacents = 1, $targetpage = "/"){
        
        //defaults
        if(!$adjacents) $adjacents = 1;
        if(!$limit) $limit = 15;
        if(!$page) $page = 1;
        if(!$targetpage) $targetpage = "/";


        //other vars
        $prev = $page - 1;                  //previous page is page - 1
        $next = $page + 1;                  //next page is page + 1
        $lastpage = ceil($totalitems / $limit);       //lastpage is = total items / items per page, rounded up.
        $lpm1 = $lastpage - 1;                //last page minus 1

        /*
          Now we apply our rules and draw the pagination object.
          We're actually saving the code to a variable in case we want to draw it more than once.
        */
        $pagination = "";
        if($lastpage > 0){ // modified to 0 so that even single page result will have a the pager showned
    
            /*$pagination .= "<ul class='pagination'>";*/
            $pagination .= "<div class='pagination' >";
            
            //previous button
            if ($page > 1)
                /* PREV */
                $pagination .= "<a onClick=\"admin_pagination('{$element_id}','{$targetpage}','{$prev}'); return false;\" href='#' class=\"number\" title=\"Previous Page\">&laquo; Previous</a>";
            else
                $pagination .= "<a href='#' onClick='return false;' class='number' title=\"Previous Page\">&laquo; Previous</a>";

            //pages
            if ($lastpage < 7 + ($adjacents * 2)){ //not enough pages to bother breaking it up
      
                for ($counter = 1; $counter <= $lastpage; $counter++){

                    if ($counter == $page)
                        $pagination .= "<a href=\"#\" class=\"number current\" title=\"{$counter}\">{$counter}</a>";
                    else
                        $pagination .= "<a onClick=\"admin_pagination('{$element_id}','{$targetpage}',{$counter}); return false;\" href=\"#\" class=\"number\" title=\"{$counter}\">{$counter}</a>";
                }
            }
            elseif($lastpage >= 7 + ($adjacents * 2)){ //enough pages to hide some
      
                //close to beginning; only hide later pages
                if($page < 1 + ($adjacents * 3)){
        
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
              
                        if ($counter == $page)
                          $pagination .= "<a href=\"#\" class=\"number current\" title=\"{$counter}\">{$counter}</a>";
                        else
                          $pagination .= "<a onClick=\"admin_pagination('{$element_id}','{$targetpage}',{$counter}); return false;\" href=\"#\" class=\"number\" title=\"{$counter}\">{$counter}</a>";
                    }
                    $pagination .= "...";
                    $pagination .= "<a onClick=\"admin_pagination('{$element_id}','{$targetpage}',{$lpm1}); return false;\" href=\"#\" class=\"number\" title=\"{$lpm1}\">{$lpm1}</a>";
                    $pagination .= "<a onClick=\"admin_pagination('{$element_id}','{$targetpage}',{$lastpage}); return false;\" href=\"#\" class=\"number\" title=\"{$lastpage}\">{$lastpage}</a>";
                }
            
                //in middle; hide some front and some back
                elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
            
                    $pagination .= "<a onClick=\"admin_pagination('{$element_id}','{$targetpage}',1); return false;\" href=\"#\" class=\"number\" title=\"1\">1</a>";
                    $pagination .= "<a onClick=\"admin_pagination('{$element_id}','{$targetpage}',2); return false;\" href=\"#\" class=\"number\" title=\"2\">2</a>";
                    $pagination .= "...";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++){
              
                        if ($counter == $page)
                            $pagination .= "<a href=\"#\" class=\"number current\" title=\"{$counter}\">{$counter}</a>";
                        else
                            $pagination .= "<a onClick=\"admin_pagination('{$element_id}','{$targetpage}',{$counter}); return false;\" href=\"#\" class=\"number\" title=\"{$counter}\">{$counter}</a>";
                    }

                    $pagination .= "...";
                    $pagination .= "<a onClick=\"admin_pagination('{$element_id}','{$targetpage}',{$lpm1}); return false;\" href=\"#\" class=\"number\" title=\"{$lpm1}\">{$lpm1}</a>";
                    $pagination .= "<a onClick=\"admin_pagination('{$element_id}','{$targetpage}',{$lastpage}); return false;\" href=\"#\" class=\"number\" title=\"{$lastpage}\">{$lastpage}</a>";
                }
                //close to end; only hide early pages
                else{
                    $pagination .= "<a onClick=\"admin_pagination('{$element_id}','{$targetpage}',1); return false;\" href=\"#\" class=\"number\" title=\"1\">1</a>";
                    $pagination .= "<a onClick=\"admin_pagination('{$element_id}','{$targetpage}',2); return false;\" href=\"#\" class=\"number\" title=\"2\">2</a>";
                    $pagination .= "...";
                    for ($counter = $lastpage - (1 + ($adjacents * 3)); $counter <= $lastpage; $counter++){
              
                        if ($counter == $page)
                            $pagination .= "<a href=\"#\" class=\"number current\" title=\"{$counter}\">{$counter}</a>";
                        else
                            $pagination .= "<a onClick=\"admin_pagination('{$element_id}','{$targetpage}',{$counter}); return false;\" href=\"#\" class=\"number\" title=\"{$counter}\">{$counter}</a>";
                    }
                }
            }
            //next button
            if ($page < $lastpage )
                $pagination .= "<a onClick=\"admin_pagination('{$element_id}','{$targetpage}',{$next}); return false;\" href=\"#\" class=\"number\" title=\"Next\">Next &raquo;</a>";
            else
                $pagination .= "<a href=\"#\" onClick='return false;' class=\"number\" title=\"Next\">Next &raquo;</a>";
                $pagination .= "</div>";
        }

        return $pagination;

    } // end function
} // end if