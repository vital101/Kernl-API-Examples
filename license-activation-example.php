<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));

// Load Composer Dependencies
require __DIR__ . "/vendor/autoload.php";

// Autoload Requests library internal classes
Requests::register_autoloader();

// The license key domain and license key you want to
// validate.
$licenseKey = $argv[1];
$domain = $argv[2];

// Print out some information.
print("Program initialized with these values:\n");
print_r(array(
    "License Key" => $licenseKey,
    "Domain" => $domain
));

// First, let"s see if the customer already exists.
$validateUrl = "https://kernl.us/api/v2/public/license/activate";
$validateQueryString = "?license=$licenseKey&domain=$domain";
$response = Requests::get($validateUrl.$validateQueryString);

// License has been activated
if($response->status_code == 200) {
    echo "\n{$response->body} \n";
}

// License exists but can't be activated because the activation limit has been reached.
if($response->status_code == 400) {
    echo "\n{$response->body} \n";
}

// License does not exist
if($response->status_code == 404) {
    echo "\n{$response->body} \n";
}

?>
