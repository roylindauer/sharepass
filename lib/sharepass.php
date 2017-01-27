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
        die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
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
	
    // Database stuff
    $mysqli = connectMysql();
    if(!($stmt = $mysqli->prepare('SELECT `data` FROM `linkdata` WHERE `key` = ?'))) {
        die("Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
    }
    if(!$stmt->bind_param('s', $encryptionKey)) {
        die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
    }
    if (!$stmt->execute()) {
        die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    }
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();
    
    if ($res->num_rows != 1) {
        die('This link no longer exists.');
    }
    
    // Delete the data
    $mysqli = connectMysql();
    if(!($stmt = $mysqli->prepare('DELETE FROM `linkdata` WHERE `key` = ?'))) {
        die("Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
    }
    if(!$stmt->bind_param('s', $encryptionKey)) {
        die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
    }
    if (!$stmt->execute()) {
        die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    }
    
    // Encrypt stuff
	$encrypt = new JaegerApp\Encrypt();
	$encrypt->setKey($encryptionKey);
	$decoded = $encrypt->decode($row['data']);
	
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
	
    // Encrypt stuff
	$encryptionKey = newEncryptionKey();
	$encrypt = new JaegerApp\Encrypt();
	$encrypt->setKey($encryptionKey);
	$encoded = $encrypt->encode($mydata);
	$guid = $encrypt->guid();
	
	// Database Stuff
    $mysqli = connectMysql();
    if(!($stmt = $mysqli->prepare('INSERT INTO `linkdata` VALUES("", ?, ?)'))) {
        die("Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error);
    }
    if(!$stmt->bind_param('ss', $encryptionKey, $encoded)) {
        die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
    }
    if (!$stmt->execute()) {
        die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    }
	
	return sprintf('%s?key=%s', getenv('ROYLSP_DOMAIN'), $encryptionKey);
}