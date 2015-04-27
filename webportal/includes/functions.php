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

    function isHavenmeester($roles) {
        return in_array('havenmeester', $roles);
    }

	function isValidID($mysqli, $id) {
		if(is_numeric($id)) {
			$sql = 'SELECT * FROM oh_transactions WHERE ID = "' . $id . '"';
			$result = $mysqli->query($sql);

			return ($result->num_rows > 0);
		}

		return false;
	}

	function toTimestamp($value) {
		$date = DateTime::createFromFormat('Ymd', $value);

        return $date->getTimestamp();
	}

    function toDate($timestamp) {
        return date("d-m-Y", $timestamp);
    }

	function formatTransaction($transaction) {
        // Timestamps omzetten
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

    function generateName($voornaam, $tussenvoegel, $achternaam) {
        if(!empty($tussenvoegel)) {
            return $voornaam . ' ' . $tussenvoegel . ' ' . $achternaam;
        } else {
            return $voornaam . ' ' . $achternaam;
        }
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

	function validateNumber($input, $min, $max) {
		if(isset($input) && !empty($input)) {
			if ((strlen($input) >= $min) && (strlen($input) <= $max) && (($num = filter_var($input, FILTER_VALIDATE_FLOAT)) !== false)) {
			    return true;
			}
		}
		return false;
	}

    function validateDate($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') == $date;
    }