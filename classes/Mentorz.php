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

		if ( isset( $_GET['edit'] ) ){
			mz_Groups::groups_edit_page( $_GET['edit'] );
		} elseif ( isset( $_GET['del'] ) ){
			mz_Groups::groups_delete_page( $_GET['del'] );
		} else {
			mz_pages::groups_page();
		}
	}

	function mentorz_users_page(){

        if( isset( $_GET['del'] ) ){
            mz_Users::users_delete_page( $_GET['groupID'], $_GET['del'] );
        } else {
            mz_Pages::users_page();
        }

	}


    /**
     *  Add the roles we're going to use.
     */
	add_role( 'mentor' , "Mentor" , array(
        'read' => true, 'edit_posts' => false, 'delete_posts' => false,  ) );
	add_role( 'student' , "Beneficiary" , array(
        'read' => true, 'edit_posts' => false, 'delete_posts' => false,  ) );

//    remove_role( 'mentor' );
//    remove_role( 'student' );


    /**
     * Generate the shortcode for page embedding
     */
	add_shortcode( 'mentorz_inbox', 'mentorz_inbox_block' );
	function mentorz_inbox_block()
	{
		mz_Generator::mentorz_inbox_block();
	}
    add_shortcode( 'mentorz_create', 'mentorz_create_block' );
    function mentorz_create_block()
    {
        mz_Generator::mentorz_create_block();
    }
    add_shortcode( 'mentorz_show', 'mentorz_show_block' );
    function mentorz_show_block()
    {
        mz_Generator::mentorz_show_block();
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

    /**
     * Send the pesky user to the inbox page. Get that page from settings
     */
    add_filter( 'login_redirect', 'upon_login_redirect' );
    function upon_login_redirect( ) {
        return PLUGIN_ROOT_PAGE;
    }


    /**
     * If users have been deleted remove them from the user group table
     */
    add_action('init','clean_up_users');
    function clean_up_users() {

        global $wpdb;

        //Get a list of all the users in the plugin
        $plugin_users = $wpdb->get_results( 'SELECT DISTINCT userid FROM ' . $wpdb->prefix . USER_GROUPS_DB_TABLE  , ARRAY_A );

        //Check they exist
        foreach ( $plugin_users as $plugin_user ) {

            //Check the user exists by trying to get their display name
            $user_detail = get_userdata( $plugin_user['userid'] );

            if ( ! $user_detail ){

                //Remove the user from the group user link table.
                remove_user( $plugin_user['userid'] );
            }

        }

    }


    /**
     * Function deleted the specified user from the user/group link table
     *
     * @param $userid
     */
    function remove_user( $userid ){

        global $wpdb;

        $wpdb->delete( $wpdb->prefix . USER_GROUPS_DB_TABLE , array( 'userid' => $userid ) );

    }


