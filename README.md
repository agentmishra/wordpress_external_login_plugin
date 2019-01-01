# External Login

See readme.txt for the main information for the plugin.
This is done to save duplication as readme.txt is required for WordPress plugin repository.

## Special Thanks
A special thank you to Ben Lobaugh for a [great article](https://ben.lobaugh.net/blog/7175/wordpress-replace-built-in-user-authentication) which I used heavily for this plugin.

## Future Plans
- Add Social Login with:
    - Facebook
    - Google
    - Github
- Ability to prepend user names in WP with a string to separate WP users from those generated with external login
- Add a custom login screen

## Deploy to WordPress
This is a note to self. This process and code needs integrating into the plugin itself.

1) Modify the version number in external-login.php
1) Modify readme.txt version
1) Modify readme.txt == Changelog ==
1) Modify readme.txt == Upgrade Notice ==
1) Tag git commit with respective version number
1) In plugins dir execute./deploy.sh
