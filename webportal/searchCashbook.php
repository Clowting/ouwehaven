<?php

require_once 'includes/globals.php';
require_once 'includes/requireSession.php';
require_once 'includes/functions.php';
require_once 'includes/connectdb.php';


if(isset($_POST['deleteID'])){
	$id = cleanInput($_POST['deleteID']);
	$dataManager->where('ID', $id);
	$remove = $dataManager->delete('oh_cashbook');
} else {

    if($_POST['date'] != null){
        $oldDate = DateTime::createFromFormat('d/m/Y', $_POST['date']);
        $date = $oldDate->format('Y-m-d');
    }
        $desc = cleanInput($_POST['desc']);
        $sender = cleanInput($_POST['sender']);
        $receiver = cleanInput($_POST['receiver']);
        $code = cleanInput($_POST['code']);
        $page = $_POST['page'];

        if(validateInput($desc, 2, 50)) {
            $dataManager->where('Beschrijving', '%' . $desc . '%', 'LIKE');
        }

        if(validateInput($sender, 2, 50)) {
            $dataManager->where('Afzender', '%' . $sender . '%', 'LIKE');
        }

        if(validateInput($receiver, 2, 50)) {
            $dataManager->where('Ontvanger', '%' . $receiver . '%', 'LIKE');
        }

        if(validateInput($code, 1, 1)) {
            $dataManager->where('Code', $code);
        }

    $data = $dataManager->get('oh_cashbook');
    $totalCount = $dataManager->count;
    $result = array();

    for($i = $page*50-50; $i < $page*50 && $i < $totalCount; $i++) {
        $result['items'][] = $data[$i];
    }

    $result['totalCount'] = $totalCount;

    echo json_encode($result);
}