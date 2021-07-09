<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
		<title>Simpla Admin</title>
		
			
        <? echo common::get_css(array('reset','style','invalid')); ?>		
		
		
		<!-- Internet Explorer Fixes Stylesheet -->
		
		<!--[if lte IE 7]>
			<link rel="stylesheet" href="<?=DEFAULT_THEME; ?>css/ie.css" type="text/css" media="screen" />
		<![endif]-->
		
		<!--                       Javascripts                       -->
	    <? echo common::get_script(array('jquery-1.3.2.min','simpla.jquery.configuration','facebox','jquery.wysiwyg')); ?>   
		
		<!-- Internet Explorer .png-fix -->
		
		
	</head>
  
	<body><div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
		
		<? include dirname(__FILE__)."/../include/companysidebar.php" ?>
		<div id="main-content"> <!-- Main Content Section with everything -->
			
			<noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					Download From <a href="http://www.exet.tk">exet.tk</a></div>
				</div>
			</noscript>
			
			<!-- Page Head -->
			<h2>Welcome <?=common::get_session("company"); ?></h2>
			<p id="page-intro">What would you like to do?</p>
			
			<ul class="shortcut-buttons-set">
				
				<li><a class="shortcut-button" href="<?=common::get_component_link(array('profile','add')); ?>"><span>
					<img src="<?=DEFAULT_THEME; ?>images/icons/profile.png" alt="icon" /><br />
					Profile
				</span></a></li>
				
				<li><a class="shortcut-button" href="<?=common::get_component_link(array('catalogue','list')); ?>"><span>
					<img src="<?=DEFAULT_THEME; ?>images/icons/catalogue.png" alt="icon" /><br />
					Catalogue
				</span></a></li>
				
				<li><a class="shortcut-button" href="<?=common::get_component_link(array('product','add')); ?>"><span>
					<img src="<?=DEFAULT_THEME; ?>images/icons/product.png" alt="icon" /><br />
					Products
				</span></a></li>
				
				<li><a class="shortcut-button" href="<?=common::get_component_link(array('category','add')); ?>"><span>
					<img src="<?=DEFAULT_THEME; ?>images/icons/category.png" alt="icon" /><br />
					Category
				</span></a></li>
				
				<li><a class="shortcut-button" href="<?=common::get_component_link(array('size','add')); ?>" rel="modal"><span>
					<img src="<?=DEFAULT_THEME; ?>images/icons/size.png" alt="icon" /><br />
					Size
				</span></a></li>
                
                <li><a class="shortcut-button" href="<?=common::get_component_link(array('design','add')); ?>" rel="modal"><span>
					<img src="<?=DEFAULT_THEME; ?>images/icons/design.png" alt="icon" /><br />
					Design
				</span></a></li>
				
			</ul><!-- End .shortcut-buttons-set -->
			
			<div class="clear"></div> <!-- End .clear -->
			
			
			<div id="footer">
				<small> <!-- Remove this notice or replace it with whatever you want -->
						&#169; Copyright 2013 Tile Store | Powered by <a href="http://waywebsolution.com">way tech</a> | <a href="#">Top</a>
				</small>
			</div><!-- End #footer -->
			
		</div> <!-- End #main-content -->
		
	</div>
</body>
  

<!-- Download From www.exet.tk-->
</html>

