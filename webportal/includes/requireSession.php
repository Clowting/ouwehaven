<?php
	include '../wp-config.php';
    require 'includes/connectdb.php';

	if(is_user_logged_in()) {
		$user = wp_get_current_user();
		$roles = $user->roles;
		$userID = $user->ID;

		$sql = "SELECT *
				FROM oh_members
				WHERE User_ID = " . $userID;

		$result = $mysqli->query($sql);

		if ($result->num_rows == 0) {
			header('Location: signup.php');
		}
	}
	else {
		header('Location: ../wp-login.php');
	}