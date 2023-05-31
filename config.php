<?php

//start session on web page
session_start();

//config.php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
// $google_client = new Google_Client();

// //Set the OAuth 2.0 Client ID
// $google_client->setClientId('374443591875-7nl8m8ct4hoo5cqpgq4jbjk9v4k1f6ja.apps.googleusercontent.com');

// //Set the OAuth 2.0 Client Secret key
// $google_client->setClientSecret('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');

// //Set the OAuth 2.0 Redirect URI
// $google_client->setRedirectUri('http://localhost/Google%20Login%20Final/index.php');

// // to get the email and profile 
// $google_client->addScope('email');

// $google_client->addScope('profile');

$client = new Google_Client();
$client->setClientId('374443591875-7nl8m8ct4hoo5cqpgq4jbjk9v4k1f6ja.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/InternshipPortal/pages/student/');
$client->addScope("email");
$client->addScope("profile");

$password = getenv('SENSITIVE_PARAMETER_VALUE'); // Assuming you have set the environment variable SENSITIVE_PARAMETER_VALUE

// Connect to the MySQL server
$conn = mysqli_connect('localhost', 'root', $password);

// Check if the connection was successful
if (!$conn) {
    die('Could not connect to MySQL server: ' . mysqli_connect_error());
}

// Create the 'student' database
$createDatabaseQuery = "CREATE DATABASE IF NOT EXISTS student";
if (mysqli_query($conn, $createDatabaseQuery)) {
    echo "Database 'student' created successfully";
} else {
    echo "Error creating database: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);


$hostname = "localhost";
$username = "root";
$password = "";
$database = "student";

$password = getenv('SENSITIVE_PARAMETER_VALUE'); // Assuming you have set the environment variable SENSITIVE_PARAMETER_VALUE
$conn = mysqli_connect('localhost', 'root', $password, 'student');

?>
