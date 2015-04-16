<?php
	include_once '../wp-config.php';
    require_once 'includes/connectdb.php';
    require_once 'includes/functions.php';

	if(is_user_logged_in()) {
		$user = wp_get_current_user();
		$roles = $user->roles;
		$userID = $user->ID;

        $sql = "SELECT *
                FROM oh_members
                WHERE User_ID = " . $userID;

        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
            header('Location: /webportal');
        }
	} else {
		header('Location: ../wp-login.php');
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php

        include_once 'includes/head.php';

    ?>

    <script type="text/javascript" src="js/signup.js"></script>

    <title>De 'n ouwe haven - Webportal</title>

</head>

<body>

    <div class="container signup">
    	<div class="row text-center">
    		<h2>Welkom bij het De 'n ouwe haven - Webportal</h1>
    		<small>Voor u verder kunt gaan hebben we een aantal extra gegevens van u nodig.</small>
    	</div>

    	<hr/>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if( isset($_POST['voornaam']) &&
                isset($_POST['achternaam']) &&
                isset($_POST['adres']) &&
                isset($_POST['postcode']) &&
                isset($_POST['woonplaats'])) {

                $voornaam = strip_tags($_POST['voornaam']);
                $achternaam = strip_tags($_POST['achternaam']);
                $adres = strip_tags($_POST['adres']);
                $postcode = strip_tags($_POST['postcode']);
                $woonplaats = strip_tags($_POST['woonplaats']);

                if(isset($_POST['tussenvoegsel']) && !empty($_POST['tussenvoegsel'])) {
                    $tussenvoegsel = strip_tags($_POST['tussenvoegsel']);
                    $sql = "INSERT INTO oh_members (User_ID, Voornaam, Tussenvoegsel, Achternaam, Adres, Postcode, Woonplaats)
                            VALUES ($userID, '$voornaam', '$tussenvoegsel', '$achternaam', '$adres', '$postcode', '$woonplaats')";

                } else {
                    $sql = "INSERT INTO oh_members (User_ID, Voornaam, Achternaam, Adres, Postcode, Woonplaats)
                            VALUES ($userID, '$voornaam', '$achternaam', '$adres', '$postcode', '$woonplaats')";
                }

                $insert = $mysqli->query($sql);

                if($insert) {
                    echo '<div class="alert alert-success" role="alert">Bedankt voor het aanvullen van de gegevens, ze zijn succesvol verwerkt!</div>';
                    echo '<p>Klik <a href="/webportal">hier</a> om verder te gaan.</p>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof er een fout is met de verbinding van de database...</div>';
                    echo '<p>Klik <a href="signup.php">hier</a> om het opnieuw te proberen.</p>';
                }

            } else {
                echo '<div class="alert alert-danger" role="alert">Het lijkt er op alsof niet alle gegevens zijn ingevuld...</div>';
                echo '<p>Klik <a href="signup.php">hier</a> om het opnieuw te proberen.</p>';
            }


        } else {
        ?>

    	<div class="row col-md-9 col-xs-7">
    		<form id="signupForm" role="form" method="POST">
    			<div class="form-group">
                    <label for="voornaam">Voornaam:</label>
    				<input type="text" class="form-control" name="voornaam" required data-progression="" data-helper="Vul hier uw voornaam in.">
    			</div>
    			<div class="form-group">
    				<label for="tussenvoegsel">Tussenvoegsel:</label>
    				<input type="text" class="form-control" name="tussenvoegsel" data-progression="" data-helper="Vul hier uw tussenvoegsel in indien u die heeft.">
    			</div>
    			<div class="form-group">
    				<label for="achternaam">Achternaam:</label>
    				<input type="text" class="form-control" name="achternaam" required data-progression="" data-helper="Vul hier uw achternaam in.">
    			</div>
    			<div class="form-group">
    				<label for="adres">Adres:</label>
    				<input type="text" class="form-control" name="adres" required data-progression="" data-helper="Vul hier uw straat en huisnummer in.">
    			</div>
    			<div class="form-group">
    				<label for="postcode">Postcode:</label>
    				<input type="text" class="form-control" name="postcode" required maxlength="7" data-progression="" data-helper="Vul hier uw postcode in.">
    			</div>
    			<div class="form-group">
    				<label for="woonplaats">Woonplaats:</label>
    				<input type="text" class="form-control" name="woonplaats" required data-progression="" data-helper="Vul hier uw woonplaats in.">
    			</div>
    			<button type="submit" class="btn btn-default">Verzenden
    			</button>
    		</form>
    	</div>

        <?php
        }
        ?>

    </div>

</body>

</html>