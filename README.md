# Kernl API Examples

This repository contains fully-baked examples of Kernl API usage written in PHP.

## Setup

- Make sure that you can run PHP from the command line: `php -v`
- Be sure that (https://getcomposer.org/)[Composer] is installed.
- Clone this repository: `git clone https://github.com/vital101/Kernl-API-Examples.git`
- In the cloned directory, install the dependencies: `composer install`

## License Activation Example

The example for activating a license is located in `license-activation-example.php`. It takes two argument:

1. License key from Kernl. This is generated (or provided by you) when you create the license.
2. The domain this license should be activated for.

To run the example, navigate to the root of the cloned repository and type the following:

`php license-activation-example.php <license-key> <domain>`

## License Validation Example

The example for validating a license is located in `license-validation-example.php`. It takes two argument:

1. License key from Kernl. This is generated (or provided by you) when you create the license.
2. The domain this license should be activated for.

To run the example, navigate to the root of the cloned repository and type the following:

`php license-validation-example.php <license-key> <domain>`


## License Management Example

The example for using Kernl's license management is in the `license-management-example.php` file. It takes 6 command line arguments.

1. Your Kernl login email address.
2. Your Kernl password
3. The plugin ID that you want the license associated with
4. The customer's email.
5. The customer's first name.
6. The customer's last name.

To run the example, navigate to the root of the cloned repository and type the following:

`php license-management-example.php <email> <password> <pluginId> <customerEmail> <customFirstName> <customerLastName>`

## Changelog Example

The example for using the Plugin Changelog API is in the `changelog-example.php` file.  It takes 3 command line arguments.

- Your email address that you log in to Kernl with.
- Your password.
- The plugin ID that you want to add/get/remove changelogs from.  You can find this id by navigating to the Plugins page in Kernl.  In the table that lists yours products, you'll see the **UUID** listed in one of the columns.  This is the ID that you need.

To run the example, navigate to the root of the cloned repository and type the following:

`php changelog-example.php <email> <password> <pluginId>`

After that, you should get output that looks like:

    A list of the changelogs associated with this plugin:

    Array
    (
        [0] => stdClass Object
            (
                [id] => 569cf92abfa565fe520da0b0
                [version] => 1.8.0
                [changelog] => "This was the best version ever."
            )

        [1] => stdClass Object
            (
                [id] => 554b4eaab1254165511382a3
                [version] => 2.0.1
                [changelog] => "Just kidding, 2.0.1 is better than 1.8.0 in every way possible."
            )

    )

    Changelog Added.  The data returned from the POST to Kernl:

    Changelog entry added to version 1.8.0

    Changelog Deleted.  The data returned from the DELETE to Kernl:

    stdClass Object
    (
        [status] => 200
        [message] => Changelog entry removed for version X.X.X
    )

# Temporary Download Link Example

The example for using the Temporary Download Link API is in the `temporary-download-link.php` file.  It takes 3 command line arguments.

- Your email address that you log in to Kernl with.
- Your password.
- The plugin ID that you want to create a temporary download link for.  You can find this id by navigating to the Plugins page in Kernl.  In the table that lists yours products, you'll see the **UUID** listed in one of the columns.  This is the ID that you need.
- The version ID that want to create a temporary download link for.

To run the example, navigate to the root of the cloned repository and type the following:

`php temporary-download-link.php <email> <password> <pluginId> <pluginVersionId>`

After that, you should get output that looks like:

    Temporary Download URL: https://kernl.us/api/v2/public/temporary-download/5a5d0feda3813f12991877fa

# Plugin / Theme Version Upload Example

The example for uploading a new plugin version is at `plugin-version-upload.php`. It takes 5 command line arguments:

1. Your email address that you log in to Kernl with.
2. Your password.
3. The plugin ID.
4. The full path the `.zip` file of your new version.
5. The version number (1.1.1, 1.1.2, etc)

To run the example, navigate to the root of the cloned repository and type the following:

`php plugin-version-upload.php email@example.com password myPluginId /path/to/plugin.zip 1.0.0`

Once completed, you will be given output for the new version that looks like:

    {"downloads":0,"isS3":true,"changelog":"none","_id":"60c697bcb1e559d0d2722bc5","uploadedDate":"2021-06-13T23:41:48.770Z","version":"1.0.1","size":164593,"fileName":"https://kernl-file-uploads.s3.amazonaws.com/2021-06-13/1623627707580/asdfasdfasdf.zip","__v":0