<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));

// Load Composer Dependencies
require __DIR__ . '/vendor/autoload.php';

// Autoload Requests library internal classes
Requests::register_autoloader();

// Set your email and password here.  For security purposes,
// you should probably read these in from environment variables.
$email = $argv[1];
$password = $argv[2];

// Plugin ID that we'll uploading a version for.
// You can find this ID by going to the plugin list page in Kernl.
$pluginId = $argv[3];

// The path to zip file for your version.
$filePath = $argv[4];

// The version number
$version = $argv[5];

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

// Create a CURl request and upload the new version
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https:/kernl.us/api/v1/plugins/$pluginId/versions",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array(
      'file'=> new CURLFILE($filePath),
      'changelog' => 'none',
      'fileSize' => '0',
      's3Url' => 'none',
      'version' => $version),
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer $authToken"
  ),
));
$response = curl_exec($curl);
curl_close($curl);
print_r($response);
?>
