<?php header('Content-type: text/html; charset=UTF-8'); ?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?= facebook_xmlns()?>>

<head>
	<title>Crown Holiday's Member Site</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="description" content="your_description" />
	<meta name="keywords" content="your_keywords_here" />
	
	<style type="text/css">
		html {overflow:hidden;}
		body { margin: 0px;	overflow: hidden; } 
	</style>
	
	<link rel="stylesheet" type="text/css" media="all" href="<?= $this->urls->css_base_url ?>/themes/basic/skins/<?= $this->skin ?>/css/style.css?v=<?= filemtime("themes/basic/skins/{$this->skin}/css/style.css"); ?>" />
	<link rel="stylesheet" type="text/css" media="all" href="<?= $this->urls->css_base_url ?>/themes/basic/skins/facebox/facebox.css?v=<?= filemtime("themes/basic/skins/facebox/facebox.css"); ?>" />
	
	<?php
	
	// render the css header defined scripts
    foreach ($this->header_scripts as $script) {
		if ($script['type'] == "css")
			echo "<link rel='stylesheet' type='text/css' media='all' href='{$script['url']}' />";
    }
	
	?>
	
	<script type="text/javascript" src="<?= $this->urls->js_base_url ?>/storage/js/libs/head.min.js?v=<?= filemtime("storage/js/libs/head.min.js"); ?>"></script>
	
	<script type="text/javascript">
	//<![CDATA[
		
		// load js
		head.js(
		    {jquery: "https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"},
		    {jqueryui: "https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"},
		    {json: "<?= $this->urls->js_base_url ?>/storage/js/libs/jquery.json.js"},
		    {facebox: "<?= $this->urls->js_base_url ?>/storage/js/libs/facebox.js?v=<?= filemtime("storage/js/libs/facebox.js"); ?>"}
		);
		
		<?php
	
		// render the css header defined scripts
		foreach ($this->header_scripts as $script) {
			if ($script['type'] == "js")
				echo "head.js('{$script['url']}');";
		}
		
		
		?>
	//]]>
	</script>
	
	
	
</head>

<body>
	<div id="container">
		<div id="menu">
		</div><!-- /menu -->

		<div id="content">
			<div id="header">
				logos and/or some menus here
			</div><!-- /header -->
			<div id="main_content">
				<?php 
					if (!isset($data)) $data = null;
					$this->load->view($view, $data);
				?>
			</div>
			<div id="footer">
			</div><!-- /footer -->
		</div><!-- /content -->
	</div><!-- /container -->
</body>
</html>