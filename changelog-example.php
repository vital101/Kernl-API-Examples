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

// Plugin id that we'll be modifying changelogs on.
// You can find this ID by going to the plugin or theme list page in Kernl.
$pluginId = $argv[3];

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
$changelogUrl = 'https://kernl.us/api/v1/changelog/' . $pluginId;
$headers = array( 'Authorization' => 'Bearer ' . $authToken );
$getResponse = Requests::get($changelogUrl, $headers);
if($getResponse->status_code != 200) {
    die("\n There was an error fetching your changelogs. \n\n");
}
$getResponseData = json_decode($getResponse->body);
echo "\nA list of the changelogs associated with this plugin: \n\n";
print_r($getResponseData);

// Next, lets add a changelog to a version.
$postUrl = 'https://kernl.us/api/v1/changelog/' . $pluginId . '/' . $getResponseData[0]->id;
$postData = array( 'changelog' => 'The best changelog message ever!' );
$postResponse = Requests::post($postUrl, $headers, $postData);
if($postResponse->status_code != 201) {
    die("\nThere was an error creating your changelog entry\n\n");
}
echo "\nChangelog Added.  The data returned from the POST to Kernl: \n\n";
print_r($postResponse->body);

// Since this is just a test, lets go ahead and delete the changelog.
$deleteUrl = 'https://kernl.us/api/v1/changelog/' . $pluginId . '/' . $getResponseData[0]->id;
$deleteResponse = Requests::delete($deleteUrl, $headers);
if($deleteResponse->status_code != 200) {
    die("\nThere was an error deleting your changelog entry\n\n");
}
echo "\n\nChangelog Deleted.  The data returned from the DELETE to Kernl: \n\n";
print_r(json_decode($deleteResponse->body));
?>
