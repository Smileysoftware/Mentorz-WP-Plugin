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
    # Email configuration
    # Email Subject Line
    define('EMAIL_SUBJECT_LINE' , 'A new message has been sent');

    # Email Message
    ### You can use the two following place holders
    # {{DISPLAYNAME}}  This will show the users own name
    # {{FROM_DISPLAYNAME]] This will show the senders name

    define('EMAIL_BODY' , '<html>
        <body style="color: #313131; background-color: #f2f2f2;">
        <h1>A new message</h1>
        <p>Hello {{DISPLAYNAME}},</p>
        <p>You have a new message from {{FROM_DISPLAYNAME}}</p>
        <p>Please log in to view the message at <a href="'.get_site_url( null , 'inbox' ).'">'.get_site_url( null , 'inbox' ).'</a></p>
        </body>
        </html>');

    # Email From Name
    define('EMAIL_FROM_NAME' , 'Talent Match Staffs');

    # Email From Email Address
    define('EMAIL_FROM_ADDRESS' , 'info@TalentMatchStaffs.co.uk');

###################################################################################################################
###################################################################################################################
################### NOTHING TO SEE BELOW HERE #####################################################################
###################################################################################################################
###################################################################################################################
################### Ere be dragons! ###############################################################################


define('VERSION' , '1.0.3');

$log = '

0.1 - Basic plugin build<br/>
0.1.6 - Plugin groups CRUD<br/>
0.1.7 - Plugin, assign mentors / users to groups<br/>
0.2 - Removal off php5.5 type OOP functionality due to using php5.4 on server.<br/>
0.2.1 - Creation of the inbox, create and show views.<br/>
0.2.2 - Ability for Mentor to send to everyone.<br/>
0.2.3 - Reorder the inbox view, was showing in reverse.<br/>
0.2.4 - Function to get display name and replace any occurances of the username with display name.<br/>
0.2.5 - All occurances of student renamed to Beneficiary.<br/>
0.3.0 - Each message created sends an email to the user.<br/>
0.3.1 - Administrators can now delete messages.<br/>
0.3.2 - After message sending, two new links to inbox or create new message.<br/>
0.4.0 - Users have the ability to reply to messages.<br/>
1.0.0 - More detail supplied on groups page in admin.<br/>
1.0.1 - Bug fix to remove users if they have been deleted.<br/>
1.0.2 - Any users that do not exist are automaitcally removed from the plugin.<br/>
1.0.3 - Issue when admin tried to send to all. If admin is not part of a group it failed.<br/>
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