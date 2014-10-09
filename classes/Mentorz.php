<?php

	add_action( 'admin_menu', 'mentorz_plugin_menu' );

	function mentorz_plugin_menu() {
		add_menu_page( "Mentorz Adminstration", "Mentorz", 'manage_options', 'mentorz', 'mentroz_plugin_options' );
		add_submenu_page( 'mentorz', 'Installation', 'Installation Guidelines', 'manage_options', 'mentorz_installation', 'mentroz_insallation_page' );
	}

	function mentroz_plugin_options() {
		mz_Pages::main_page();
	}

	function mentroz_insallation_page() {
		mz_Pages::installation_page();
	}

	add_role( 'mentor' , "Mentor"  );
	add_role( 'student' , "Student" );


	add_shortcode( 'mentorz_inbox', 'mentorz_inbox_block' );
	function mentorz_inbox_block()
	{
		mz_Generator::mentorz_inbox_block();
	}


//http://codex.wordpress.org/Function_Reference/wp_insert_post
// $post = array(
//   'post_content'   => 'GOSH', // The full text of the post.
//   'post_name'      => 'inbox_new', // The name (slug) for your post
//   'post_title'     => 'Inbox', // The title of your post.
//   'post_status'    => 'publish', // Default 'draft'.
//   'post_type'      => 'page', // Default 'post'.
//   //'post_author'    => [ <user ID> ] // The user ID number of the author. Default is the current user ID.
//   //'ping_status'    => [ 'closed' | 'open' ] // Pingbacks or trackbacks allowed. Default is the option 'default_ping_status'.
//   //'post_parent'    => [ <post ID> ] // Sets the parent of the new post, if any. Default 0.
//   //'menu_order'     => [ <order> ] // If new post is a page, sets the order in which it should appear in supported menus. Default 0.
//   //'to_ping'        => // Space or carriage return-separated list of URLs to ping. Default empty string.
//   //'pinged'         => // Space or carriage return-separated list of URLs that have been pinged. Default empty string.
//   //'post_password'  => [ <string> ] // Password for post, if any. Default empty string.
//   //'guid'           => // Skip this and let Wordpress handle it, usually.
//   //'post_content_filtered' => // Skip this and let Wordpress handle it, usually.
//   //'post_excerpt'   => [ <string> ] // For all your post excerpt needs.
//   //'post_date'      => [ Y-m-d H:i:s ] // The time post was made.
//   //'post_date_gmt'  => [ Y-m-d H:i:s ] // The time post was made, in GMT.
//   //'comment_status' => [ 'closed' | 'open' ] // Default is the option 'default_comment_status', or 'closed'.
//   //'post_category'  => [ array(<category id>, ...) ] // Default empty.
//   //'tags_input'     => [ '<tag>, <tag>, ...' | array ] // Default empty.
//   //'tax_input'      => [ array( <taxonomy> => <array | string> ) ] // For custom taxonomies. Default empty.
//   //'page_template'  => [ <string> ] // Requires name of template file, eg template.php. Default empty.
// );
$post = array(
  'post_title'    => 'My post',
  'post_content'  => 'This is my post.',
  'post_status'   => 'publish',
  'post_author'   => 1,
  'post_category' => array(8,39)
);
//wp_insert_post( $post );
