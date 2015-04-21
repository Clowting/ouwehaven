<?php
	include '../wp-config.php';
    require 'includes/connectdb.php';

	if(is_user_logged_in()) {
		$user = wp_get_current_user();
		$roles = $user->roles;
		$userID = $user->ID;

		// Store member details in session
		if(!isset($_SESSION['member_details'])) {
			$sql = "SELECT *
					FROM oh_members
					WHERE User_ID = " . $userID;

			$result = $mysqli->query($sql);

			if ($result->num_rows == 0) {
				header('Location: signup.php');
			}
			else {
				// Store details in session
				$_SESSION['member_details'] = $result->fetch_assoc();
			}
		}

		$memberID = $_SESSION['member_details']['ID'];
	}
	else {
		header('Location: ../wp-login.php');
	}