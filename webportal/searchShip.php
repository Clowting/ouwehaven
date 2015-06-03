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
    $dataManager->where('Naam', '%' . $naamSchip . '%', 'LIKE');
}

if(validateNumber($minLengte, 1, 16) && validateNumber($maxLengte, 1, 16)) {
    $dataManager->where('Lengte', Array($minLengte, $maxLengte), 'BETWEEN');
} else if (validateNumber($minLengte, 1, 16)) {
    $dataManager->where('Lengte', $minLengte, '>=');
} else if (validateNumber($maxLengte, 1, 16)) {
    $dataManager->where('Lengte', $maxLengte, '<=');
}

if(validateInput($naamEigenaar, 2, 512)) {
    $naamArray = explode(' ', $naamEigenaar);
    array_walk($naamArray, function(&$value) {
        $value = '%' . $value . '%';
    });

    foreach ($naamArray as $naam) {
        $dataManager->where('(Voornaam LIKE "' . $naam . '" OR Achternaam LIKE "' . $naam . '" OR Tussenvoegsel LIKE "' . $naam . '")');
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