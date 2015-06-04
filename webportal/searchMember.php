<?php
require_once 'includes/globals.php';
require_once 'includes/requireSession.php';
require_once 'includes/functions.php';
require_once 'includes/connectdb.php';

$naamEigenaar = $_POST['naam'];
$adres = $_POST['adres'];
$postcode = $_POST['postcode'];
$woonplaats = $_POST['woonplaats'];
$page = $_POST['page'];

if(validateInput($naamEigenaar, 2, 512)) {
    $naamArray = explode(' ', $naamEigenaar);
    array_walk($naamArray, function(&$value) {
        $value = '%' . $value . '%';
    });

    foreach ($naamArray as $naam) {
        $dataManager->where('(Voornaam LIKE "' . $naam . '" OR Achternaam LIKE "' . $naam . '" OR Tussenvoegsel LIKE "' . $naam . '")');
    }
}

if(validateInput($adres, 2, 128)) {
    $dataManager->where('Adres', '%' . $adres . '%', 'LIKE');
}

if(validateInput($postcode, 4, 7)) {
    $dataManager->where('Postcode', '%' . $postcode . '%', 'LIKE');
}

if(validateInput($woonplaats, 2, 128)) {
    $dataManager->where('Woonplaats', '%' . $woonplaats . '%', 'LIKE');
}

$data = $dataManager->get('oh_members');
$totalCount = $dataManager->count;
$result = array();

for($i = $page*50-50; $i < $page*50 && $i < $totalCount; $i++) {
    $result['items'][] = $data[$i];
}

$result['totalCount'] = $totalCount;

echo json_encode($result);