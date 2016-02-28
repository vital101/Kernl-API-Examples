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

// Plugin or theme id that we'll be adding/removing purchase codes from.
// You can find this ID by going to the plugin or theme list page in Kernl.
$pluginOrThemeId = $argv[3];

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
$statusCodeUrl = 'https://kernl.us/api/v1/purchase-codes/' . $pluginOrThemeId;
$headers = array( 'Authorization' => 'Bearer ' . $authToken );
$postData = array(
    'code' => 'abc123def456ghi789',
    'notes' => 'I made this code with the Kernl API!'
);
$postResponse = Requests::post($statusCodeUrl, $headers, $postData);
if($postResponse->status_code != 201) {
    die("\nThere was an error creating your status code\n\n");
}
$postReturnData = json_decode($postResponse->body);
echo "\nPurchase Code Added.  The data returned from the POST to Kernl: \n\n";
print_r($postReturnData);

// Since this is just a test, lets go ahead and delete the code.
$statusCodeDeleteUrl = 'https://kernl.us/api/v1/purchase-codes/' . $pluginOrThemeId . '/' . $postReturnData->_id;
$headers = array( 'Authorization' => 'Bearer ' . $authToken );
$deleteResponse = Requests::delete($statusCodeDeleteUrl, $headers, array());
if($deleteResponse->status_code != 200) {
    die("\nThere was an error removing your purchase code.\n\n");
}
echo "\n\n{$deleteResponse->body}\n\n";
?>
