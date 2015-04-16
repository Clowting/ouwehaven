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

	function isValidID($mysqli, $id) {
		if(is_numeric($id)) {
			$sql = 'SELECT * FROM oh_transactions WHERE ID = "' . $id . '"';
			$result = $mysqli->query($sql);

			return ($result->num_rows > 0);
		}

		return false;
	}

	function toDate($value) {
		$day = substr($value, 6, 2);
		$month = substr($value, 4, 2);
		$year = substr($value, 0, 4);

		return $day . '-' . $month . '-' . $year;
	}

	function formatTransaction($transaction) {
		// Datums omzetten
		$transaction["Rentedatum"] = toDate($transaction["Rentedatum"]);
		$transaction["Boekdatum"] = toDate($transaction["Boekdatum"]);

		// Boekcode omzetten
		$boekcodes = array(
			"ac" => "Acceptgiro",
			"ba" => "Betaalautomaat",
			"bc" => "Betalen contactloos",
			"bg" => "Bankgiro opdracht",
			"cb" => "Crediteuren betaling",
			"db" => "Diverse boekingen",
			"eb" => "Bedrijven Euro-incasso",
			"ei" => "Euro-incasso",
			"fb" => "FiNBOX",
			"ga" => "Geldautomaat Euro",
			"gb" => "Geldautomaat VV",
			"id" => "iDeal",
			"kh" => "Kashandeling",
			"ma" => "Machtiging",
			"sb" => "Salaris betaling",
			"sp" => "Spoedbetaling",
			"tb" => "Eigen rekening"
		);

		$transaction["Boekcode"] = $boekcodes[$transaction["Boekcode"]];

		return $transaction;
	}

	function getTransaction($mysqli, $id) {
		if(isValidID($mysqli, $id)) {
			$sql = 'SELECT * FROM oh_transactions WHERE ID = "' . $id . '"';
			$result = $mysqli->query($sql);

			return formatTransaction($result->fetch_assoc());
		}
		
		return false;
	}

	function getTransactions($mysqli, $code) {
		$transactions = array();

		$sql = 'SELECT * FROM oh_transactions WHERE Code = "' . $code . '"';
		$result = $mysqli->query($sql);

		if($result) {
			while($transaction = $result->fetch_assoc()) {
				array_push($transactions, formatTransaction($transaction));
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