# Kernl API Examples

This repository contains fully-baked examples of Kernl API usage written in PHP.

## Setup

- Make sure that you can run PHP from the command line: `php -v`
- Be sure that (https://getcomposer.org/)[Composer] is installed.
- Clone this repository: `git clone https://github.com/vital101/Kernl-API-Examples.git`
- In the cloned directory, install the dependencies: `composer install`

## Purchase Code Example

The example for using the Purchase Code API is in the `purchase-code-example.php` file.  It takes 3 command line arguments.

- Your email address that you log in to Kernl with.
- Your password.
- The plugin or theme ID that you want to add/remove purchase codes from.  You can find this id by navigating to the Plugins or Themes page in Kernl.  In the table that lists yours products, you'll see the **UUID** listed in one of the columns.  This is the ID that you need.

To run the example, navigate to the root of the cloned repository and type the following:

`php purchase-code-example.php <email> <password> <plugin/theme id>`

After that, you should get output that looks like:

    Purchase Code Added.  The data returned from the POST to Kernl:

    stdClass Object
    (
        [__v] => 0
        [user] => 3333746e7a1fa8663be442a9
        [notes] => I made this code with the Kernl API!
        [code] => abc123def456ghi789
        [_id] => 56d99d2505f75e07a7757e
        [created_date] => 2016-02-28T13:43:57.332Z
        [active] => 1
    )


    Purchase code deleted.

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