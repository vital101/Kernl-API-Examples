<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load Composer Dependencies
require __DIR__ . '/vendor/autoload.php';

// Autoload Requests library internal classes
Requests::register_autoloader();

// Set your email and password here.  For security purposes,
// you should probably read these in from environment variables.
$email = $argv[1];
$password = $argv[2];

// Plugin ID that we'll be generating a temporary download link for.
// You can find this ID by going to the plugin list page in Kernl.
$pluginId = $argv[3];

// The version ID that we'll be generating a temporary download link for.
$pluginVersionId = $argv[4];

// Make an authentication request
$authURL = 'https://kernl.us/api/v1/auth';
$authPostData = array(
    'email' => $email,
    'password' => $password
);
$authResponse = Requests::post($authURL, array(), $authPostData);
if($authResponse->status_code != 200) {
    die("\nInvalid email or password.\n\n");
}
$authToken = $authResponse->body;

// Now that you have a token you can start making requests against the Kernl API.
$statusCodeUrl = "https://kernl.us/api/v1/plugins/$pluginId/versions/$pluginVersionId/temporary-download-link?lengthInSeconds=30";
$headers = array( 'Authorization' => 'Bearer ' . $authToken );
$postResponse = Requests::post($statusCodeUrl, $headers);
if($postResponse->status_code != 201) {
    die("\nThere was an error creating your temporary download link.\n\n");
}
echo "\nTemporary Download URL: $postResponse->body\n\n";
?>
