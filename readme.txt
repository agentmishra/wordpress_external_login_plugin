=== External Login ===
Contributors: tbenyon
Donate link: https://www.paypal.me/tombenyon
Tags: external login, external, database, login, users, db, WordPress, different, username, password, hashing, md, md2, md4, md5, bcrypt, sha, sha1, sha256, sha384, sha512
Requires at least: 4.6
Tested up to: 4.9
Stable tag: 1.1.2
Requires PHP: 7.0.0
License: MIT

External Login allows users to log in to the WordPress site with a different database of users.


== Description ==

External Login allows you to log in in to your WordPress site using an 'external database' instead of the WordPress database. This means if you already have a login system you can integrate that into your WordPress site. The 'external database' that you would like to use does not have to be a WordPress database.

The plugin will re-create users in the WordPress database which has has two benefits:
    1. It will allow you to use WordPress correctly with other plugins that require a named user to be logged in.
    2. If the 'external database' is not available, you can allow the plugin to log them in with the local WordPress version of their user.

== Features ==

* Use your current table of users in a different database to login to WordPress
* Map the names for your database fields against the required WordPress fields
* Map roles from your 'external database' to those found in WordPress e.g. a student in the 'external database' becomes an editor in the WordPress database.
* Every time a user logs in, their WordPress user will be updated with the details from the 'external database'.
* Many password hashing methods are supported including:
    * bcrypt
    * md2
    * md4
    * md5
    * sha1
    * sha256
    * sha384
    * sha512
    * and more...
* Support for separate password salts for each password
* Support for one salt for all passwords
* Support for salts being prepended or appended to the password
* Ability to fall back to the generated WordPress user for login if the 'external database' is unavailable.
* Test the connection in the settings menu to make sure your data is being pulled correctly
* Option to delete plugin data on plugin deactivation


== Installation ==

1. Install the plugin through the WordPress plugins screen directly, or upload the plugin files to the `/wp-content/plugins/external-login` directory.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Take a backup of your WordPress Database
1. Access the plugin settings by clicking the link on the plugins page or via wp-admin -> settings -> External Login (see first screenshot).
1. Begin to fill out the settings page.
1. BEFORE TICKING THE 'Enable External Login' BOX - Test the connection using the "Test" button.


== Frequently Asked Questions ==

= How do I add a port to the database connection? =

For ports that differ the standard 3306, add them to the end of the host separated by a colon eg: 'localhost:3306'.

= What values can I set in wp-config.php? =
Here is a full listing of possible fields and values.

* Enable External Login
    * Constant Name
        * EXTERNAL_LOGIN_OPTION_ENABLE_EXTERNAL_LOGIN
    * Possible Values
        * on
        * off

* Disable Local Login
    * Constant Name
        * EXTERNAL_LOGIN_OPTION_DISABLE_LOCAL_LOGIN
    * Possible Values
        * on
        * off

* Delete Settings on Plugin Deactivation
    * Constant Name
        * EXTERNAL_LOGIN_OPTION_DELETE_PLUGIN_SETTINGS
    * Possible Values
        * on
        * off

* Database Name
    * Constant Name
        * EXTERNAL_LOGIN_OPTION_DB_NAME
    * Possible Values
        * Any String

* Database Host
    * Constant Name
        * EXTERNAL_LOGIN_OPTION_DB_HOST
    * Possible Values
        * Any String

* Database Username
    * Constant Name
        * EXTERNAL_LOGIN_OPTION_DB_USERNAME
    * Possible Values
        * Any String

* Database Password
    * Constant Name
        * EXTERNAL_LOGIN_OPTION_DB_PASSWORD
    * Possible Values
        * Any String

* Database Hash Type
    * Constant Name
        * EXTERNAL_LOGIN_OPTION_HASH_ALGORITHM
    * Possible Values
        * bcrypt
        * md2
        * md4
        * md5
        * sha1
        * sha256
        * sha384
        * sha512
        * ripemd128
        * ripemd160
        * ripemd256
        * ripemd320
        * whirlpool
        * tiger128,3
        * tiger160,3
        * tiger192,3
        * tiger128,4
        * tiger160,4
        * tiger192,4
        * snefru
        * gost
        * adler32
        * crc32
        * crc32b
        * haval128,3
        * haval160,3
        * haval192,3
        * haval224,3
        * haval256,3
        * haval128,4
        * haval160,4
        * haval192,4
        * haval224,4
        * haval256,4
        * haval128,5
        * haval160,5
        * haval192,5
        * haval224,5
        * haval256,5
        * none

* Salting Method
    * Constant Name
        * EXTERNAL_LOGIN_OPTION_DB_SALTING_METHOD
    * Possible Values
        * none
        * one
        * all

* Salt Location
    * Constant Name
        * EXTERNAL_LOGIN_OPTION_DB_SALT_LOCATION
    * Possible Values
        * before
        * after

* Password Salt
    * Constant Name
        * EXTERNAL_LOGIN_OPTION_DB_SALT
    * Possible Values
        * Any String

* Table Name
    * Constant Name
        * EXLOG_DBSTRUCTURE_TABLE
    * Possible Values
        * Any String

* Username Field Name
    * Constant Name
        * EXLOG_DBSTRUCTURE_USERNAME
    * Possible Values
        * Any String

* Password Field Name
    * Constant Name
        * EXLOG_DBSTRUCTURE_PASSWORD
    * Possible Values
        * Any String

* Salt Field Name
    * Constant Name
        * EXLOG_DBSTRUCTURE_SALT
    * Possible Values
        * Any String

* E-mail Field Name
    * Constant Name
        * EXLOG_DBSTRUCTURE_EMAIL
    * Possible Values
        * Any String

* First Name Field Name
    * Constant Name
        * EXLOG_DBSTRUCTURE_FIRST_NAME
    * Possible Values
        * Any String

* Last Name Field Name
    * Constant Name
        * EXLOG_DBSTRUCTURE_LAST_NAME
    * Possible Values
        * Any String

* Role Field Name
    * Constant Name
        * EXLOG_DBSTRUCTURE_ROLE
    * Possible Values
        * Any String

= I need an extra feature. Can you add it? =

Get in contact. I'll normally add simple functionality for free and pretty quick!


== Screenshots ==

1. Main Settings View
2. Functionality Settings
3. Database Connection Settings
4. Database Table Mapping Settings
5. Password Hashing Settings
6. Role Settings
7. Test Results


== Changelog ==

= 1.1.2 =
* Remove old data from the DB if you switch to using wp-config to store your settings.

= 1.1.1 =
* Improve plugin documentation

= 1.1.0 =
* Add ability to store settings in wp-config

= 1.0.3 =
* Add further sanitisation of data in SQL command
* Refactor code

= 1.0.2 =
* Update readme.txt to better present plugin information again.

= 1.0.1 =
* Update readme.txt to better present plugin information.

= 1.0.0 =
* Initial production version


== Upgrade Notice ==

= 1.1.2 =
* Remove old data from the DB if you switch to using wp-config to store your settings.

= 1.1.1 =
* Improve plugin documentation

= 1.1.0 =
* Add ability to store settings in wp-config

= 1.0.3 =
* Add further sanitisation of data in SQL command
* Refactor code

= 1.0.2 =
* Update readme.txt to better present plugin information again.

= 1.0.1 =
* Update readme.txt to better present plugin information.

= 1.0.0 =
* Initial production version


== FUNCTIONALITY WARNINGS AND LIMITATIONS ==

1. ALWAYS take a backup of your database and test the functionality before using this plugin in production.
2. Users created in WordPress will be overwritten if users in the external database have the same username. This could be fixed by appending usernames with a separate string.
3. Edits to a user made in WordPress will be overwritten when the user logs back in with the 'external database'. This is only the case for fields that are being pulled from the external database.


== Security Notes ==

__Database User__
It is recommended that you create a new Database user to access the external database. This way you can set appropriate permissions to the user so that they do not have write access.

__Hashing__
For the security of your users, your 'external database' should be hashing your users passwords. Although support is given for other hashing methods, 'bcrypt' is advised as it uses SLOW hashing. Without this it would be far easier for someone to derive your users password through a brute force attack if they gained access to your database.

It is also highly recommended that a salt is used. This is done by default with 'bcrypt'. Using one salt for all passwords is supported but it is recommended to use a separate salt for each password as a different field in your database. This helps prevent the use of 'rainbow tables' to derive your users passwords.

For explanation and more information on this I recommend [this article](https://martinfowler.com/articles/web-security-basics.html) starting from the section "Hash and Salt Your Users' Passwords".

__Storing Settings in wp-config.php__
You may prefer to store your settings in 'wp-config.php'. This could have security benefits, so long as you are careful not to store your code in a publicly accessible repository and you ensure your wp-config file cannot be accessed on the server.

Below is an example of code that can be added to 'wp-config.php'.

`
// ** EXTERNAL LOGIN SETTINGS ** //
/** EXLOG - The External Database Name */
define('EXTERNAL_LOGIN_OPTION_DB_NAME', 'dojo2016');

/** EXLOG - The External Database Host */
define('EXTERNAL_LOGIN_OPTION_DB_HOST', 'localhost');

/** EXLOG - The External Database Username */
define('EXTERNAL_LOGIN_OPTION_DB_USERNAME', 'root');

/** EXLOG - The External Database Password */
define('EXTERNAL_LOGIN_OPTION_DB_PASSWORD', 'root');

/** EXLOG - Password Salt */
define('EXTERNAL_LOGIN_OPTION_DB_SALT', 'ksjefh2lkrh2r2oh23');
`

You can of course set these with environment variables if you wish in the following way:

`
/** EXLOG - The External Database Name */
define('EXTERNAL_LOGIN_OPTION_DB_NAME', getenv('MY_EXLOG_DB_NAME_ENVIRONMENT_VARIABLE'));
`

All settings (except from those mapping roles) can currently be set this way. For a full list and possible settings see the "FAQ" question - "What values can I set in wp-config.php?".


== Special Thanks ==

A special thank you to Ben Lobaugh for a [great article](https://ben.lobaugh.net/blog/7175/wordpress-replace-built-in-user-authentication) which I used heavily for this plugin.


== DONATE ==
Like the plugin and want to [buy me a beer](https://www.paypal.me/tombenyon)? Well, thank you!
