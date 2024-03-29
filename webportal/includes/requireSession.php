<?php
	include '../wp-config.php';
    require 'includes/connectdb.php';

	if(is_user_logged_in()) {
		$user = wp_get_current_user();
		$roles = $user->roles;
		$userID = $user->ID;
        $userMail = $user->user_email;

		// Store member details in session
		if(!isset($_SESSION['member_details'])) {
			$dataManager->where('User_ID', $userID);
			$user = $dataManager->get('oh_members', 1);

			if ($dataManager->count == 0) {
				header('Location: signup.php');
			}
			else {
				// Store details in session
				$_SESSION['member_details'] = $user[0];
			}
		}

		$memberID = $_SESSION['member_details']['ID'];
	}
	else {
        add_filter('login_redirect', '/webportal', 10, 3);
		auth_redirect();
	}