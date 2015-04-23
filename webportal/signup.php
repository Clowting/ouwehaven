<?php
    require_once 'includes/globals.php';
	include_once '../wp-config.php';
    require_once 'includes/connectdb.php';
    require_once 'includes/functions.php';

	if(is_user_logged_in()) {
		$user = wp_get_current_user();
		$roles = $user->roles;
		$userID = $user->ID;

        $dataManager->where('User_ID', $userID);
        $user = $dataManager->get('oh_members', 1);

        if ($dataManager->count > 0) {
            header('Location: /webportal');
        }
	}
    else {
        add_filter('login_redirect', '/webportal', 10, 3);
        auth_redirect();
	}
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <?php

        include_once 'includes/head.php';

    ?>

    <title><?php echo SITE_TITLE; ?> - Registreren</title>

</head>

<body>

    <div class="container signup">
    	<div class="row text-center">
    		<h2>Welkom bij het webportal van <?php echo SITE_TITLE; ?></h2>
    		<small>Voor u verder kunt gaan hebben we een aantal extra gegevens van u nodig.</small>
    	</div>

    	<hr/>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $voornaam = cleanInput($_POST['voornaam']);
            $tussenvoegsel = cleanInput($_POST['tussenvoegsel']);
            $achternaam = cleanInput($_POST['achternaam']);
            $adres = cleanInput($_POST['adres']);
            $postcode = cleanInput($_POST['postcode']);
            $woonplaats = cleanInput($_POST['woonplaats']);

            if( validateInput($voornaam, 2, 64) &&
                validateInput($achternaam, 2, 64) &&
                validateInput($adres, 4, 128) &&
                validateInput($postcode, 6, 7) &&
                validateInput($woonplaats, 2, 128)) {

                $data = array(
                    'User_ID' => $userID,
                    'Voornaam' => $voornaam,
                    'Achternaam' => $achternaam,
                    'Adres' => $adres,
                    'Postcode' => $postcode,
                    'Woonplaats' => $woonplaats
                );

                if(validateInput($tussenvoegsel, 1, 16)) {
                    $data['Tussenvoegsel'] = $tussenvoegsel;
                }

                $insert = $dataManager->insert('oh_members', $data);

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

    	<div class="row">
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

    <!-- Footer -->
    <?php

        include_once 'includes/footer.php';

    ?>

</body>

</html>