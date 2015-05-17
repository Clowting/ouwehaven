<?php
require_once 'includes/globals.php';
require_once 'includes/requireSession.php';
require_once 'includes/functions.php';
require_once 'includes/connectdb.php';

$naamSchip = cleanInput($_POST['naam']);
$minLengte = $_POST['minLengte'];
$maxLengte = $_POST['maxLengte'];
$naamEigenaar = $_POST['naamEigenaar'];
$page = $_POST['page'];

if(validateInput($naamSchip, 2, 128)) {
    $dataManager->orWhere('Naam', '%' . $naamSchip . '%', 'LIKE');
}

if(validateNumber($minLengte, 1, 16) && validateNumber($maxLengte, 1, 16)) {
    $dataManager->orWhere('Lengte', Array($minLengte, $maxLengte), 'BETWEEN');
} else if (validateNumber($minLengte, 1, 16)) {
    $dataManager->orWhere('Lengte', $minLengte, '>=');
} else if (validateNumber($maxLengte, 1, 16)) {
    $dataManager->orWhere('Lengte', $maxLengte, '<=');
}

if(validateInput($naamEigenaar, 2, 512)) {
    $naamArray = explode(' ', $naamEigenaar);
    array_walk($naamArray, function(&$value) {
        $value = '%' . $value . '%';
    });

    foreach ($naamArray as $naam) {
        $dataManager->orWhere('Voornaam', $naam, 'LIKE');
        $dataManager->orWhere('Achternaam', $naam, 'LIKE');
        $dataManager->orWhere('Tussenvoegsel', $naam, 'LIKE');
    }
}

$data = $dataManager->get('oh_search_ship');
$totalCount = $dataManager->count;
$result = array();

for($i = $page*50-50; $i < $page*50 && $i < $totalCount; $i++) {
    $result['items'][] = $data[$i];
}

$result['totalCount'] = $totalCount;

echo json_encode($result);