
* * * * * * * * * * * * * * * * * * * *
Kit-Catalogue Installation Instructions
* * * * * * * * * * * * * * * * * * * *



INSTALLING

The installation wizard will guide you through the changes required to get
Kit-Catalogue up and running at your institution.

To start the wizard, browse to your installation's  /install/  folder.



UPGRADING?

If you are upgrading an existing installation, unzip the contents of the latest
and overwrite your existing Kit-Catalogue site.  You should then run the "upgrade"
option in the installation wizard to ensure your database is fully updated too. 

On existing installations, your installer should be disabled.
To renable the installer, change your local config file and enable this setting:

	$config['installer.enabled'] = true;

You can now run the upgrade wizard by browsing to your installations /install/ folder.

Remember to disable the installer again when you're done!



INSTALLING MANUALLY

If you wish to bypass the wizard, then these are the basic things you should 
do to get Kit-Catalogue working...


(1) Have an Apache web server running at least PHP 5.3 and MySQL 4.  Unzip the
Kit-Catalogue zip-file into a new website, or sub-folder of an existing website.
 

(2) If this is a fresh installation, you will need to enable your local folder.
To do this, rename the  /new_local/  folder to  /local/

Within your local folder, edit  local_config.php  and change the configuration
settings within it to setup connections to your MySQL database, LDAP, etc.
Future installations/upgrades of Kit-Catalogue will not overwrite the settings
you define in your local folder. This should smooth future upgrades, and
reduce the work required to keep Kit-Catalogue up-to-date.


(3) Create a  /writable/  folder, and give PHP write permissions to it.
This folder will be used for uploading and importing items, images and 
associated resources.

Kit-Catalogue will also use it for cache files and intermediate processing steps.


(4) Make sure Apache is configured with mod_rewrite enabled.

To do this, edit httpd.conf and...

Make sure the AllowOverride option is on:

	AllowOverride All

Ensure that mod_rewrite is enabled by uncommenting this line:

	LoadModule rewrite_module modules/mod_rewrite.so


(5) Kit-Catalogue now defaults to using PHP's Mysqli extension, which is normally
installed and enabled by default.  You can opt to use the older, and soon to be 
deprecated mysql extension by altering your db configuration in the Kit-Catalogue
local config file.


(6) Install and load the database tables into your MySQL database by running the
database script file:

	install/install_steps/install_db.sql


(7) Kit-Catalogue comes with a built in user account called "admin", with the
following details:

username: admin
password: admin

For security reasons, you should change this accounts password immediately.

The installation wizard will guide you through choosing a new password, or you
can make the changes through Kit-Catalogue's administration area once you've
logged in. 

Even if you are not using the database authentication (e.g. just using LDAP
authentication) you should change the default admin password! 


(8) For security reasons, once you have installed Kit-Catalogue and made sure
it is all working properly, you should edit your local config and disable the
installer using this setting.

	$config['installer.enabled'] = false;

If you leave the installer available, malicious users can use it to
damage/delete your catalogue!

For added security, you could delete the  /install/  folder to prevent
unauthorised access, but if you later upgrade or reinstall Kit-Catalogue, you
will have a new version of the  /install/  folder created, so disabling it in
your config is a must.


