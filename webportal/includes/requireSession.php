<?php
	include '../wp-config.php';
    require 'includes/connectdb.php';

	if(is_user_logged_in()) {
		$user = wp_get_current_user();
		$roles = $user->roles;
		$userID = $user->ID;

		// Store member details in session
		if(!isset($_SESSION['member_details'])) {
			$dataManager->where('User_ID', $userID);
			$user = $dataManager->get('oh_members', 1);

			if ($dataManager->count == 0) {
				header('Location: signup.php');
			}
			else {
				// Store details in session
				$_SESSION['member_details'] = $user;
			}
		}

		$memberID = $_SESSION['member_details']['ID'];
	}
	else {
		header('Location: ../wp-login.php');
	}