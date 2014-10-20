<?php

class mz_Func
{

	public static function user_has_access(){

		if ( ! current_user_can( 'manage_options' ) )  {
			wp_die( __( NO_ACCESS_MESSAGE ) );
		}

	}


	public static function check_if_installed(){

		if ( file_exists( plugins_url() . '/mentorz/flg/installed.txt' )){
			return true;
		} else {
			return false;
		}

	}

	public static function install_it_then(){

		//What do we need to do.
		#Create the flag file
		#Create a postID flag for the index page
		#Build the database table
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

		#Create the flag file
		Self::create_installed_flag_file();

	}

	


	private static function create_installed_flag_file(){

		$file = WP_PLUGIN_DIR . '/mentorz/flg/installed.txt';

		$installFile = fopen( $file , 'w');
		fwrite($installFile,'INSTALLED ' . date('r'));
		fclose($installFile);

	}

	public static function get_current_user_role () {
	    
	    global $current_user;
	    get_currentuserinfo();
	    $user_roles = $current_user->roles;
	    $user_role = array_shift($user_roles);

	    return $user_role;
	}

	public static function get_current_users_group( $userID ){

		global $wpdb;

		$groupID = $wpdb->get_row('SELECT DISTINCT groupid FROM ' . $wpdb->prefix . USER_GROUPS_DB_TABLE . ' WHERE userid = '.$userID);

		return $groupID;

	}


}