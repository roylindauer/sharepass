<?php

function newEncryptionKey() {
	return uniqid();
}

function isLinkRequest() {
	if (isset($_GET['key'])) {
		return true;
	}
}

function processLink() {
	$encryptionKey = filter_var($_GET['key']);
	
	// get encrypted data from db based on $encryptionKey...
	
	$encrypt = new JaegerApp\Encrypt();
	$encrypt->setKey($encryptionKey);
	$decoded = $encrypt->decode($encoded);
	
	return $decoded;
}

function generateLink() {
	
	$mydata = '';
	if (isset($_POST['mydata'])) {
		$mydata = filter_var($_POST['mydata']);
	}
	
	$encryptionKey = newEncryptionKey();
	
	$encrypt = new JaegerApp\Encrypt();
	$encrypt->setKey($encryptionKey);
	$encoded = $encrypt->encode($mydata);
	$guid = $encrypt->guid();
	
	// encrypt the data
	
	// save to db
	// INSERT INTO linkdata VALUES('', KEY, ENCRYPTED_DATA);
	
	return sprintf('https://sharepass.roylindauer.com/?key=%s', $encryptionKey);
}