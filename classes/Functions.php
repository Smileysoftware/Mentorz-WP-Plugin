<?php

class mz_Func
{

    /**
     * Get the users access level
     */
	public static function user_has_access(){

		if ( ! current_user_can( 'manage_options' ) )  {
			wp_die( __( NO_ACCESS_MESSAGE ) );
		}

	}


    /**
     * Check if the system is installed
     *
     * @return bool
     */
	public static function check_if_installed(){

		if ( file_exists( plugins_url() . '/mentorz/flg/installed.txt' )){
			return true;
		} else {
			return false;
		}

	}

    /**
     * Install the system
     */
	public static function install_it_then(){

		//What do we need to do.
		#Create the flag file
		#Create a postID flag for the index page
		#Build the database tables
		global $wpdb;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
		$table_name = $wpdb->prefix . GROUPS_DB_TABLE; 
		
		$sql = '
			CREATE TABLE IF NOT EXISTS ' . $table_name . ' (
			  	groupid int(11) NOT NULL AUTO_INCREMENT,
				groupname varchar(100),
				groupactive int(1),
				UNIQUE KEY groupid (groupid)
			);
		';
		dbDelta($sql);
		
		$table_name = $wpdb->prefix . USER_GROUPS_DB_TABLE; 
		$sql = '
			CREATE TABLE IF NOT EXISTS ' . $table_name . ' (
			  	usergroupid int(11) NOT NULL AUTO_INCREMENT,
				userid int(11),
				groupid int(11),
				mentor int(1),
				UNIQUE KEY usergroupid (usergroupid)
			);
		';
		dbDelta($sql);

        $table_name = $wpdb->prefix . MESSAGES_DB_TABLE;
        $sql = '
			CREATE TABLE IF NOT EXISTS ' . $table_name . ' (
			  	messageid int(11) NOT NULL AUTO_INCREMENT,
				messageto int(11),
				messagefrom int(11),
				subject varchar(200),
				body varchar(999),
				stamp varchar(100),
				UNIQUE KEY messageid (messageid)
			);
		';
        dbDelta($sql);

		#Create the flag file
		mz_Func::create_installed_flag_file();

	}


    /**
     * Create a flag file to denote the system is installed
     */
	private static function create_installed_flag_file(){

		$file = WP_PLUGIN_DIR . '/mentorz/flg/installed.txt';

		$installFile = fopen( $file , 'w');
		fwrite($installFile,'INSTALLED ' . date('r'));
		fclose($installFile);

	}

    /**
     * Determine the users role
     *
     * @return mixed
     */
	public static function get_current_user_role () {
	    
	    global $current_user;
	    get_currentuserinfo();
	    $user_roles = $current_user->roles;
	    $user_role = array_shift($user_roles);

	    return $user_role;
	}

    /**
     * Get the current users group
     * Returns the groupID
     *
     * @param $userID
     * @return mixed
     */
	public static function get_current_users_group( $userID ){

		global $wpdb;

		$groupID = $wpdb->get_row('SELECT DISTINCT groupid FROM ' . $wpdb->prefix . USER_GROUPS_DB_TABLE . ' WHERE userid = '.$userID, ARRAY_A);

		return $groupID["groupid"];

	}


    /**
     * Get an array of all the users in the group
     *
     * @param $groupID
     * @return mixed
     */
    public static function get_all_students_in_group( $groupID ){

        global $wpdb;

        $students = $wpdb->get_results( 'SELECT userid FROM ' . $wpdb->prefix . USER_GROUPS_DB_TABLE . ' WHERE groupID = '.$groupID . ' AND mentor = 0', ARRAY_A );

        return $students;

    }


    /**
     * Get the email address of the user by userID
     *
     * @param $userID
     * @return mixed
     */
    public static function get_users_email_address( $userID ){

        $user_info = get_userdata( $userID );
        $email = $user_info->user_email;

        return $email;
    }


    /**
     * Get the display name of the user by the userID
     *
     * @param $userID
     * @return mixed
     */
    public static function get_users_display_name( $userID ){

        $user_info = get_userdata( $userID );
        $display_name = $user_info->display_name;

        return $display_name;
    }


    /**
     * Generate the email message
     *
     * @param $userID
     * @param $fromUserID
     * @return mixed|string
     */
    public static function build_email_message( $userID , $fromUserID ){

        $message = EMAIL_BODY;

        //Get rid of the DISPLAYNAME
        $message = str_replace( '{{DISPLAYNAME}}' , mz_Func::get_users_display_name( $userID ) , $message );

        //Get the from display name
        $message = str_replace( '{{FROM_DISPLAYNAME}}' , mz_Func::get_users_display_name( $fromUserID ) , $message );


        return $message;

    }


    public static function delete_message( $messageID ){

        global $wpdb;

        if ( $messageID ){

            $wpdb->delete( $wpdb->prefix . MESSAGES_DB_TABLE , array( 'messageid' => $messageID ) );

            $back = $_SERVER['HTTP_REFERER'];
            echo '<a href="' . $back . '" class="button">Back</a>';

        }

    }

    public static function get_group_mentor( $groupID ){

        global $wpdb;

        $mentorID = $wpdb->get_row('SELECT userid FROM ' . $wpdb->prefix . USER_GROUPS_DB_TABLE . ' WHERE groupid = ' . $groupID .' AND mentor = 1', ARRAY_A );

        if ( isset( $mentorID ) ){
            $mentorName = mz_Func::get_users_display_name( $mentorID['userid'] );

            return $mentorName;
        } else {
            return false;
        }



    }
}