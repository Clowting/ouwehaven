<?php
	
	$menuToggled = $_COOKIE['menu-toggled'];

	if($menuToggled == 'true') {
		echo '<div id="wrapper" class="toggled">';
	} else {
		echo '<div id="wrapper">';
	}

?>