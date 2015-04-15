<?php
	include '../wp-config.php';
	if(is_user_logged_in()) {
		$user = wp_get_current_user();
		$roles = $user->roles;
		$userID = $user->ID;
	} else {
		header('Location: ../wp-login.php');
	};

	require 'includes/functions.php';
	require 'includes/connectdb.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php

        include_once 'includes/head.php';

    ?>

    <title>De 'n ouwe haven - Webportal</title>

</head>

<body>

    <div class="container signup">
    	<div class="row text-center">
    		<h2>Welkom bij het De 'n ouwe haven - Webportal</h1>
    		<small>Voor u verder kunt gaan hebben we een aantal extra gegevens van u nodig.</small>
    	</div>

    	<hr/>

    	<div class="row">
    		<form role="form">
    			<div class="form-group">
    			<label for="voornaam">Voornaam:</label>
    				<input type="text" class="form-control" id="voornaam">
    			</div>
    			<div class="form-group">
    				<label for="tussenvoegsel">Tussenvoegsel:</label>
    				<input type="text" class="form-control" id="tussenvoegsel">
    			</div>
    			<div class="form-group">
    				<label for="achternaam">Achternaam:</label>
    				<input type="text" class="form-control" id="achternaam">
    			</div>
    			<button type="submit" class="btn btn-default">Verzenden</button>
    		</form>
    	</div>

    </div>

</body>

</html>