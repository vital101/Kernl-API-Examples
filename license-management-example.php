<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));

// Load Composer Dependencies
require __DIR__ . "/vendor/autoload.php";

// Autoload Requests library internal classes
Requests::register_autoloader();

// Set your email and password here.  For security purposes,
// you should probably read these in from environment variables.
$email = $argv[1];
$password = $argv[2];

// Set the plugin that we will be adding the license to.
// You can find this ID by going to the plugin detail page in Kernl.
$pluginId = $argv[3];

// Set the customer email, first name, and last name
$customerEmail = $argv[4];
$customerFirstName = $argv[5];
$customerLastName = $argv[6];

// Print out some information.
print("Program initialized with these values:\n");
print_r(array(
    "Plugin ID" => $pluginId,
    "Customer Email" => $customerEmail,
    "Customer First Name" => $customerFirstName,
    "Customer Last Name" => $customerLastName
));

// Make an authentication request
$authURL = "https://kernl.us/api/v1/auth";
$authPostData = array(
    "email" => $email,
    "password" => $password
);
$authResponse = Requests::post($authURL, array(), $authPostData);
if($authResponse->status_code != 200) {
    die("\nInvalid email or password.\n\n");
}
$authToken = $authResponse->body;

// Now that you have a token you can start making requests against the Kernl API.

// First, let"s see if the customer already exists.
$customerUrl = "https://kernl.us/api/v2/customers?q=" . $customerEmail;
$headers = array( "Authorization" => "Bearer " . $authToken );
$response = Requests::get($customerUrl, $headers);
if($response->status_code != 200) {
    die("\n There was an error fetching your customers. \n\n");
}
$response = json_decode($response->body);
print("\nThe customers associated with query for {$customerEmail}\n");
print_r($response);

// If customer exists, select them. Otherwise, create the customer.
if (count($response) == 1) {
    print("\nCustomer already exists. No need to create.\n");
    $customer = $response[0];
} else {
    print("\nCustomer does not exist. Creating.\n");
    $customerUrl = "https://kernl.us/api/v2/customers";
    $response = Requests::post($customerUrl,$headers, array(
        "email" => $customerEmail,
        "first_name" => $customerFirstName,
        "last_name" => $customerLastName,
        "notes" => "This customer is great!"
    ));
    if ($response->status_code != 201) {
        die("\nThere was an error creating your customer.\n\n");
    }
    $customer = json_decode($response->body);
}
print("\nThe Kernl customer object we are working with now.\n");
print_r($customer);

// We have a customer to work with, so now we can create a license and associate it
// with them and the plugin.
$licenseUrl = "https://kernl.us/api/v2/license";
$response = Requests::post($licenseUrl, $headers, array(
    "customer" => $customer->_id, // required
    "key" => "some-license-key", // required
    "product" => $pluginId
));
if ($response->status_code != 201) {
    die("\nThere was an error creating your license.\n\n");
}
$license = json_decode($response->body);
print("\nThe new Kernl license object:\n");
print_r($license);


// Since this is just a test, lets go ahead and delete the license.
$deleteUrl = "https://kernl.us/api/v2/license/{$license->_id}";
$deleteResponse = Requests::delete($deleteUrl, $headers);
if($deleteResponse->status_code != 204) {
    die("\nThere was an error deleting your license\n\n");
}
echo "\n\nLicense deleted.\n\n";

// And also delete the customer
// DELETE https://kernl.us/api/v2/customers/customerID
$deleteUrl = "https://kernl.us/api/v2/customers/{$customer->_id}";
$deleteResponse = Requests::delete($deleteUrl, $headers);
if($deleteResponse->status_code != 200) {
    die("\nThere was an error deleting your customer\n\n");
}
echo "\n\nCustomer deleted.\n\n";
?>
