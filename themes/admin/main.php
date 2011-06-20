<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
 
	<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
		<title>Jagged-Alliance Administration</title>
	  

		<link rel="stylesheet" href="/themes/admin/css/reset.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="/themes/admin/css/style.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="/themes/admin/css/invalid.css" type="text/css" media="screen" />	
		
		<!--[if lte IE 7]>
			<link rel="stylesheet" href="/themes/admin/css/ie.css" type="text/css" media="screen" />
		<![endif]-->

        <script type="text/javascript">
        //<![CDATA[

           var base_url = "<?= $this->urls->base_url; ?>";
           var fb_base_url = '<?= $this->urls->fb_base_url; ?>';
    	   var assets_base_url = '<?= $this->urls->assets_base_url; ?>';
    	   var css_base_url = '<?= $this->urls->css_base_url; ?>';
    	   var js_base_url = '<?= $this->urls->js_base_url; ?>';

            var fb_params = {};
            var fb_params_string = '';
            var fb_session_string = '';
            var fb_signed_request_string = '';
    		var extra_params = "";

        //]]>
        </script>
  
		<script type="text/javascript" src="/storage/js/libs/jquery.min.js"></script>
		<script type="text/javascript" src="/storage/admin/js/jquery.wysiwyg.js"></script>
        <!-- <script type="text/javascript" src="/storage/js/libs/facebox.js"></script> -->
        <script type="text/javascript" src="/storage/admin/js/facebox.js"></script>
        <script type="text/javascript" src="/storage/admin/js/simpla.jquery.configuration.js"></script>
        <script type="text/javascript" src="/storage/js/apps/core.js"></script>
        <script type="text/javascript" src="/storage/js/libs/jquery.json.js"></script>
        
		<!-- 
		<script type="text/javascript" src="/storage/js/libs/jquery.class.js"></script>
		<script type="text/javascript" src="/storage/js/app/se.plugins.js"></script>
        <script type="text/javascript" src="/storage/js/app/se.core.js"></script>
        <script type="text/javascript" src="/storage/js/libs/jquery.scrollTo-min.js"></script> -->
		
		<!--[if IE 6]>
			<script type="text/javascript" src="/storage/admin/js/DD_belatedPNG_0.0.7a.js"></script>
			<script type="text/javascript">
				DD_belatedPNG.fix('.png_bg, img, li');
			</script>
		<![endif]-->

<?php

  // load and render the haeder_scripts
  foreach ($this->header_scripts as $script) {
    if ($script['type'] == 'javascript') {
      echo "<script type='text/javascript' src='{$script['url']}'></script>\n";
    } else if ($script['type'] == 'stylesheet') {
      echo "<link rel='stylesheet' href='{$script['url']}' type='text/css' />\n";
    }
  } // end foreach

?>
		
	</head>
  
	<body>
    
    <div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
		
<?php 
        $this->load->view('sidebar_view');
?>
		
		<div id="main-content"> <!-- Main Content Section with everything -->
			
			<noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					</div>
				</div>
			</noscript>
            
<?php			
            if (!isset($data)) $data = null;
            if (empty($module)) {
                $this->load->view($view, $data);
            } else {
                // $this->load->module_view($module, $view, $data);
            }
?>			

			<div id="footer">
				<small>
						Space Empires &#169; Copyright 2010, All Right Reserved | Powered by <a href="http://nvinium.com" target='_blank'>Nvinium Games, Inc.</a>
				</small>
			</div><!-- End #footer -->
			
		</div> <!-- End #main-content -->
		
	</div>

<?php

  // load and render the footer_scripts
  foreach ($this->footer_scripts as $script) {
    if ($script['type'] == 'javascript') {
      echo "<script type='text/javascript' src='{$script['url']}'></script>\n";
    }
  } // end foreach

?>
    
    </body>
  
</html>
