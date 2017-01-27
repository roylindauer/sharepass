<?php

/**
 * Connect to MySQL Server
 *
 * @return mysqli|false
 */
function connectMysql() {
    $mysqli = new mysqli(
        getenv('ROYLSP_MYSQL_HOST'),
        getenv('ROYLSP_MYSQL_USER'),
        getenv('ROYLSP_MYSQL_PASS'),
        getenv('ROYLSP_MYSQL_NAME'));

    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        return false;
    }
    
    return $mysqli;
}

/**
 * Generate a unique encryption key
 *
 * @return string
 */
function newEncryptionKey() {
	return uniqid();
}

/**
 * Retrieve encrypted data from database by $key, decrypt, and return to user
 *
 * @return string
 */
function processLink() {
	$encryptionKey = filter_var($_GET['key']);
	
	// get encrypted data from db based on $encryptionKey...
    $data = 'IMAGINE THIS IS ENCRYPTED DATA';
	
	$encrypt = new JaegerApp\Encrypt();
	$encrypt->setKey($encryptionKey);
	$decoded = $encrypt->decode($data);
	
	return $decoded;
}

/**
 * Encrypt data for user and return a link with encryption key
 *
 * @return string
 */
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
	
	return sprintf('%s?key=%s', getenv('ROYLSP_DOMAIN'), $encryptionKey);
}