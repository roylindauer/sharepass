<?php

function isLinkRequest() {
	if (isset($_GET['key'])) {
		return true;
	}
}

function processLink() {
	$key = filter_var($_GET['key']);
	
	return 'This is my unencrypted data';
}

function generateLink() {
	
	$mydata = '';
	if (isset($_POST['mydata'])) {
		$mydata = filter_var($_POST['mydata']);
	}
	
	// encrypt the data
	
	// save to db
	// INSERT INTO linkdata VALUES('', KEY, ENCRYPTED_DATA);
	
	return 'https://tools.roylindauer.com/?key=1234';
}