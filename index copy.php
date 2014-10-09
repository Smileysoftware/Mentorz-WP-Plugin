<?php




add_action( 'admin_menu', 'mentorz_plugin_menu' );

add_role( 'mentor' , "Mentor"  );
add_role( 'student' , "Student" );

function mentorz_plugin_menu() {
	add_menu_page( "Mentorz Adminstration", "Mentorz", 'manage_options', 'mentorz', 'mentroz_plugin_options' );
	//add_options_page( 'My Plugin Options', 'My Plugin', 'manage_options', 'my-unique-identifier', 'my_plugin_options' );
}

function mentroz_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
	echo '<p>Here is where the form would go if I actually had options.</p>';
	echo '</div>';
}

function isMentor($roles){
	if ( in_array( 'mentor' , $roles )){
		return true;
	} else {
		return false;
	}
}

function isStudent(){

}

function isAllowed(){

}


function foobar_func( $atts ){
	echo "foo and bar";

	//Get the current User ID
	$user_ID = get_current_user_id();
	
	//Get the object of data for this user.
	$usr = get_userdata( $user_ID );

	//Dump the roles
	echo '<pre>';
	var_dump( $usr->roles );
	echo '</pre>';

	//If the user has role of mentor
	// if ( in_array( 'mentor' , $usr->roles )){
	// 	echo ' YAY';
	// } else {
	// 	echo "NAY";
	// }

	if( isMentor( $usr->roles ) ){
		echo "Mentor";
	} else {
		echo "Dunno";
	}
	
}
add_shortcode( 'foobar', 'foobar_func' );