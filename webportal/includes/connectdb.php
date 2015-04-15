<?php

	$mysqli = new mysqli('clowting.me', 'ouwehaven', '8UcYeurzZ2qDLDYsFzaFNbY6', 'ouwehaven');

	if ($mysqli->connect_error) {
	    die('Connect Error (' . $mysqli->connect_errno . ') '
	            . $mysqli->connect_error);
	}