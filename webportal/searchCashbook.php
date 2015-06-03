<?php

require_once 'includes/globals.php';
require_once 'includes/requireSession.php';
require_once 'includes/functions.php';
require_once 'includes/connectdb.php';


if(isset($_POST['deleteID'])){
	$id = cleanInput($_POST['deleteID']);
	$dataManager->where('ID', $id);
	$remove = $dataManager->delete('oh_cashbook');
}else{
	

if($_POST['date'] != null){
	$oldDate = DateTime::createFromFormat('d/m/Y', $_POST['date']);
	$date = $oldDate->format('Y-m-d');
}	 
	$desc = cleanInput($_POST['desc']);
	$sender = cleanInput($_POST['sender']);
	$receiver = cleanInput($_POST['receiver']);
	$code = cleanInput($_POST['code']);
	$page = $_POST['page'];
	 
	$sql = "SELECT * FROM oh_cashbook WHERE Beschrijving = '".$desc."' OR Datum ='".$date."' OR Afzender ='".$sender."' OR Ontvanger ='".$receiver."' OR Code ='".$code."' ORDER BY Datum DESC";

$data = $dataManager->rawQuery($sql);
$totalCount = $dataManager->count;
$result = array();

for($i = $page*50-50; $i < $page*50 && $i < $totalCount; $i++) {
	$result['items'][] = $data[$i];
}

$result['totalCount'] = $totalCount;

echo json_encode($result);
}
?>