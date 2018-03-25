=== External Login ===
Contributors: tbenyon
Donate link: https://www.paypal.me/tombenyon
Tags: external login, external, database, login, users, db, WordPress, different, username, password, hashing, md, md2, md4, md5, bcrypt, sha, sha1, sha256, sha384, sha512
Requires at least: 4.6
Tested up to: 4.9
Stable tag: 1.3.0
Requires PHP: 5.6.34
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

= What hashes are available and which does my external database use? =

Below is a list of the available hashing options. Within each there are examples of what the hashed string might look like.

* bcrypt
    * $2b$10$MaTFwF7Ov2JRTTPnV.I4X.q0KQ3VVAiwTzULlPnBYeSBkBztnXfJO
    * $2y$10$fEg5j9N5zrrqq9Bjm7yoB.Xprd9iZZfO3pgHZNl0FiLMnqMDlSQh.
    * $2a$06$qAOKdDYnSWcSp6UI1Hpkau/8sRfsvahYvRPq5vpDxMRMzPdQNGw8m
* phpass
    * $P$BEldufbwSc73mu/epnZsHmmnX7/.Ni0
* phpcrypt
    * This is for use with other algorithms that store the algorithm, salt and hash in the same field in the external databse. These are:
        * Standard DES:
            * rl.3StKT.4T8M
        * Extended DES:
            * _J9..rasmBYk8r9AiWNc
        * MD5:
            * $1$rasmusle$rISCgZzpwk3UhDidwXvin0
        * Blowfish:
            * $2a$07$usesomesillystringfore2uDLvp1Ii2e./U9C8sBjqp8I90dH6hi
        * SHA-256:
            * $5$rounds=5000$usesomesillystri$KqJWpanXZHKq2BOB43TSaYhEWsQ1Lr5QNyPCDH/Tp.6
        * SHA-512:
            * $6$rounds=5000$usesomesillystri$D4IrlXatmP7rx3P3InaxBeoomnAihCKRVQP22JZ6EY47Wc6BkroIuUUBOov1i.S5KPgErtP/EN5mcO.ChWQW21
* md2
    * f03881a88c6e39135f0ecc60efd609b9
* md4
    * 8a9d093f14f8701df17732b2bb182c74
* md5
    * 5f4dcc3b5aa765d61d8327deb882cf99
* sha1
    * 5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8
* sha256
    * 5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8
* sha384
    * 9c1565e99afa2ce7800e96a73c125363c06697c5674d59f227b3368fd00b85ead506eefa90702673d873cb2c9357eafc
* sha512
    * b109f3bbbc244eb82441917ed06d618b9008dd09b3befd1b5e07394c706a8bb980b1d7785e5976ec049b46df5f1326af5a2ea6d103fd07c95385ffab0cacbc86
* ripemd128
    * c9c6d316d6dc4d952a789fd4b8858ed7
* ripemd160
    * 2c08e8f5884750a7b99f6f2f342fc638db25ff31
* ripemd256
    * f94cf96c79103c3ccad10d308c02a1db73b986e2c48962e96ecd305e0b80ef1b
* ripemd320
    * c571d82e535de67ff5f87e417b3d53125f2d83ed7598b89d74483e6c0dfe8d86e88b380249fc8fb4
* whirlpool
    * 74dfc2b27acfa364da55f93a5caee29ccad3557247eda238831b3e9bd931b01d77fe994e4f12b9d4cfa92a124461d2065197d8cf7f33fc88566da2db2a4d6eae
* tiger128,3
    * d476a6b8b5c35ce912781497d02d09fa
* tiger160,3
    * d476a6b8b5c35ce912781497d02d09faeb8aa05a
* tiger192,3
    * d476a6b8b5c35ce912781497d02d09faeb8aa05a489223f5
* tiger128,4
    * b1e057f1b2e82506f13d4d43fd17d8b8
* tiger160,4
    * b1e057f1b2e82506f13d4d43fd17d8b843e173a8
* tiger192,4
    * b1e057f1b2e82506f13d4d43fd17d8b843e173a8a1ea3f7c
* snefru
    * 8ec80c31fab12b5f7930e6c9288c3076852aeef8f560a9ed91fb2e33838e6871
* gost
    * db4d9992897eda89b50f1d3208db607902da7e79c6f3bc6e6933cc5919068564
* adler32
    * 0f910374
* crc32
    * 35c246d5
* crc32b
    * 4fa7edbb
* haval128,3
    * 2221b19499669a2da53c49caf3c5e5be
* haval160,3
    * 9e997134ef585a1b143574ddc38cb8617c597230
* haval192,3
    * d8d7e2b0c045418daf3e696f1c819f3da8b751fb539780a0
* haval224,3
    * 46f2dff67ec34847e71128386569438e9186f9b0f993f77c06f4794e
* haval256,3
    * 502ef024050f4b58d9cdf57b9d1e847ca53b7cdbbbe31071bb2f2176824ca4aa
* haval128,4
    * a2ac4348ff7caf14d2a16a9bb207315a
* haval160,4
    * 757921aaa14a05363dd9bea6a5cafa622333d191
* haval192,4
    * 7670901e6a800b1787e08555e62ae0e68310b0d66e3ad4d4
* haval224,4
    * 5857f727b00252f6bd7abf6569d658bdab66003407b6db8989805a03
* haval256,4
    * 68e61bcce9204cf87e8c7563bd32074124205299d43205d1a086d3566adda324
* haval128,5
    * 9bec7b503c2680c94cefcadee5c72c93
* haval160,5
    * 756700c90d00421529549def07a3512b258c42f4
* haval192,5
    * e7218675e85e01c85cc196ab4aabc99cc218749b7944a788
* haval224,5
    * b21cbe5ac421cce98ee10a5d2f65607d59095c3777de339c1e978efd
* haval256,5
    * a7dac1b901376073284fbe145b37ffe6bcf6fc1ae94728186939ce91bcf73e51
* none

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
        * phpass
        * phpcrypt
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

= 1.3.0 =
* Make plugin compatible with PHP 5.6.34.

= 1.2.1 =
* Fix broken Test button and improve options page description link.

= 1.2.0 =
* Add new hashing methods.

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

= 1.3.0 =
* Make plugin compatible with PHP 5.6.34.

= 1.2.1 =
* Fix broken Test button and improve options page description link.

= 1.2.0 =
* Add new hashing methods.

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
