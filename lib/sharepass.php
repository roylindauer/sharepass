<?php

function getEncryptionKey() {
	return 'testkey';
}

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
	
	$encryption_key = 'testkey';
	
	$encrypt = new JaegerApp\Encrypt();
	$encrypt->setKey(getEncryptionKey());
	$encoded = $encrypt->encode($mydata);
	$decoded = $encrypt->decode($encoded);
	$guid = $encrypt->guid();
	
	print_r($encoded);
	print_r($decoded);
	print_r($guid);
	
	// encrypt the data
	
	// save to db
	// INSERT INTO linkdata VALUES('', KEY, ENCRYPTED_DATA);
	
	return 'https://tools.roylindauer.com/?key=1234';
}