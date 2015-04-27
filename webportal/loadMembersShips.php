<?php
require_once 'includes/globals.php';
require_once 'includes/requireSession.php';
require_once 'includes/functions.php';
require_once 'includes/connectdb.php';

/**
 * Created by Thijs Clowting.
 * User: Thijs Clowting
 * Date: 27-4-2015
 * Time: 16:24
 */
$eigenaarID = cleanInput($_GET['eigenaarID']);

if(validateNumber($eigenaarID, 1, 11)) {

    $dataManager->join("oh_member_ship ms", "s.ID=ms.Ship_ID", "LEFT");
    $dataManager->where("ms.Member_ID", $eigenaarID);
    $ships = $dataManager->get('oh_ships s', NULL, 's.ID, s.Naam');

    foreach($ships as $ship) {
        echo '<option value="' . $ship["ID"] . '">' . $ship["Naam"] . '</option>';
    }

}