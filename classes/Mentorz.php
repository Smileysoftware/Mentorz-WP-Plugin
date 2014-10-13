<?php

	add_action( 'admin_menu', 'mentorz_plugin_menu' );

	function mentorz_plugin_menu() {
		add_menu_page( "Mentorz Adminstration", "Mentorz", 'manage_options', 'mentorz', 'mentorz_plugin_options' );
		add_submenu_page( 'mentorz', 'Installation', 'Installation Guidelines', 'manage_options', 'mentorz_installation', 'mentorz_insallation_page' );

		add_submenu_page( 'mentorz', 'Groups', 'Groups Adminstration', 'manage_options', 'mentorz_groups', 'mentorz_groups_page' );
	}


	## Generate my pages
	function mentorz_plugin_options() {
		mz_Pages::main_page();
	}

	function mentorz_insallation_page() {
		mz_Pages::installation_page();
	}

	function mentorz_groups_page(){
		mz_pages::groups_page();
	}


	## Add the roles were going to use.
	add_role( 'mentor' , "Mentor"  );
	add_role( 'student' , "Student" );


	## Generate the shortcode for page embedding
	add_shortcode( 'mentorz_inbox', 'mentorz_inbox_block' );
	function mentorz_inbox_block()
	{
		mz_Generator::mentorz_inbox_block();
	}

	##If the system is not installed, well, install it.
	if ( ! mz_Func::check_if_installed() ){
		mz_Func::install_it_then();
	}



