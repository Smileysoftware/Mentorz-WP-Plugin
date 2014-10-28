<?php 

###################################################################################################################
# These settings define the pages that the system will look for and redirect to on the front end of the website
#
###################################################################################################################
# Root file for the plugin. This will display the users inbox
define('PLUGIN_ROOT_PAGE' , 'inbox');
#
###################################################################################################################
# Show the form where the user will create a new message
define('PLUGIN_CREATE_PAGE' , 'inbox/create');
#
###################################################################################################################
# The page which shows the content of a single message
define('PLUGIN_READ_PAGE' , 'inbox/show');
#
###################################################################################################################

###################################################################################################################
###################################################################################################################
################### NOTHING TO SEE BELOW HERE #####################################################################
###################################################################################################################
###################################################################################################################
################### Ere be dragons! ###############################################################################


define('VERSION' , '0.2.1');

$log = '

0.1 - Basic plugin build<br/>
0.1.6 - Plugin groups CRUD<br/>
0.1.7 - Plugin, assign mentors / users to groups<br/>
0.2 - Removal off php5.5 type OOP functionality due to using php5.4 on server.<br/>
0.2.1 - Creation of the inbox, create and show views.<br/>

';

define('VERSION_LOG' , $log);

define('CLASSES_DIR' , 'classes');
define('NO_ACCESS_MESSAGE' , 'You do not have sufficient permissions to access this page.');

define('GROUPS_DB_TABLE' , 'mentorz_groups');
define('USER_GROUPS_DB_TABLE' , 'mentorz_user_groups');
define('MESSAGES_DB_TABLE' , 'mentorz_messages');

require_once( CLASSES_DIR . '/' . 'Functions.php');
require_once( CLASSES_DIR . '/' . 'Mentorz.php');
require_once( CLASSES_DIR . '/' . 'Groups.php');
require_once( CLASSES_DIR . '/' . 'Users.php');
require_once( CLASSES_DIR . '/' . 'Pages.php');
require_once( CLASSES_DIR . '/' . 'Generator.php');