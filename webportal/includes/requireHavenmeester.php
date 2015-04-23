<?php

	require_once 'requireSession.php';
	require_once 'functions.php';

	// $roles is defined in 'requireSession.php'
	if(!isHavenmeester($roles)) {
		header('Location: /webportal');
	}