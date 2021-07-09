<?php
	common::logout_user();
	common::set_message(6);
	common::redirect_to(common::get_component_link(array('home', 'home')));
?>