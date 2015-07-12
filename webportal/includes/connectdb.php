<?php

	require_once "MysqliDb.php";

	// Set up a new datamanager TODO Import the database and change the details below
	$dataManager = new MysqliDb('host', 'username', 'password', 'database_name');