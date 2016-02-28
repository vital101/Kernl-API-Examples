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

To run the example, navigate to the root of the cloned repository and type: `php purchase-code-example.php <email> <password> <plugin/theme id>`

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
