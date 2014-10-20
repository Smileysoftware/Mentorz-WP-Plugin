<?php

    /**
     * Build the admin menu
     */
	add_action( 'admin_menu', 'mentorz_plugin_menu' );

    /**
     * Function to generate the admin menu
     */
	function mentorz_plugin_menu() {
		add_menu_page( "Mentorz Administration", "Mentorz", 'manage_options', 'mentorz', 'mentorz_plugin_options' );
		add_submenu_page( 'mentorz', 'Installation', 'Installation Guidelines', 'manage_options', 'mentorz_installation', 'mentorz_insallation_page' );

		add_submenu_page( 'mentorz', 'Groups', 'Groups Administration', 'manage_options', 'mentorz_groups', 'mentorz_groups_page' );
		add_submenu_page( 'mentorz', 'Users', 'Users Administration', 'manage_options', 'mentorz_userss', 'mentorz_users_page' );
	}


	/**
     * Generate my pages
     */
	function mentorz_plugin_options() {
		mz_Pages::main_page();
	}

	function mentorz_insallation_page() {
		mz_Pages::installation_page();
	}

	function mentorz_groups_page(){

		if ( $_GET['edit'] ){
			mz_Groups::groups_edit_page( $_GET['edit'] );
		} elseif ( $_GET['del'] ) {
			mz_Groups::groups_delete_page( $_GET['del'] );
		} else {
			mz_pages::groups_page();
		}
	}

	function mentorz_users_page(){

        if( $_GET['del'] ){
            mz_Users::users_delete_page( $_GET['groupID'], $_GET['del'] );
        } else {
            mz_Pages::users_page();
        }

	}


    /**
     *  Add the roles we're going to use.
     */
	add_role( 'mentor' , "Mentor"  );
	add_role( 'student' , "Student" );


    /**
     * Generate the shortcode for page embedding
     */
	add_shortcode( 'mentorz_inbox', 'mentorz_inbox_block' );
	function mentorz_inbox_block()
	{
		mz_Generator::mentorz_inbox_block();
	}

    /**
     * If the system is not installed, well, install it.
     */
	if ( ! mz_Func::check_if_installed() ){
		mz_Func::install_it_then();
	}


    /**
     * Enqueue the javascript used for the accordion
     */
	add_action('init','load_js');
	function load_js() {
		wp_enqueue_script( 'script', plugins_url( '/mentorz/js/script.js' ));
	}



