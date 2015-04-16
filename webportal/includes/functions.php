<?php

	function isAdmin($roles) {
		return in_array('administrator', $roles);
	}
	
	function isLid($roles) {
		return in_array('lid', $roles);
	}

	function isPenningmeester($roles) {
		return in_array('penningmeester', $roles);
	}

	function getTransactions($mysqli, $code) {
		$transactions = array();

		$sql = 'SELECT * FROM oh_transactions WHERE Code = "' . $code . '"';
		$result = $mysqli->query($sql);

		if($result) {
			while($transaction = $result->fetch_assoc()) {
				array_push($transactions, $transaction);
			}
		}

		return $transactions;
	}

	function cleanInput($input) {
		return preg_replace("/[^[:alnum:][:space:]]/ui", '', $input);
	}

	function validateInput($input, $min, $max) {
		if(isset($input) && !empty($input)) {
			if((strlen($input) >= $min) && (strlen($input) <= $max)) {
				return true;
			}
		}
		return false;
	}