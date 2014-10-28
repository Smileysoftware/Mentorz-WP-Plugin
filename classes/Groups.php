<?php

class mz_Groups{


	/**
	 * Displays the new group form
	 */
	public static function newGroupForm( $error = null)
	{
		//New group form
		echo '<h3>Add a new group</h3>';

		if ( $error ){
			echo '<div class="error"><p>';
		         _e( $error );
		    echo '</p></div>';
		}

		echo '<form action="' . str_replace( '%7E', '~', $_SERVER['REQUEST_URI']) . '" method="post">';
		echo '<label for="mz_group_name">Group Name</label> ';
		echo '<input type="text" class="regular-text" id="mz_group_name" name="mz_group_name" placeholder="Group Name">';
		echo '<input type="submit" value="Add New" class="button button-primary"/>';
		echo '</fomr>';
	}

	




	/**
	 * Group edit page
	 */
	public static function groups_edit_page( $groupID )
	{

		global $wpdb;

		echo '<h3>Edit a group</h3>';

		//Sanity check
		if ( ! $groupID ){

			echo '<div class="error"><p>';
		         _e( 'It looks like there was a problem' );
		    echo '</p></div>';

			exit();
		}

		//Update on submit
		if ( $_POST ){

			echo '<div class="updated"><p>';
		         _e( 'Group name saved' );
		    echo '</p></div><br/>';

			$wpdb->query( $wpdb->prepare( 'UPDATE ' . $wpdb->prefix . GROUPS_DB_TABLE . ' SET groupname = %s	WHERE groupid = ' . $groupID, $_POST['mz_group_name'] ) );

		}

		//Get the data for the ID passed
		$data = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . GROUPS_DB_TABLE . ' WHERE groupid = ' . $groupID, ARRAY_A);

		echo '<form action="' . str_replace( '%7E', '~', $_SERVER['REQUEST_URI']) . '" method="post">';
			echo '<label for="mz_group_name">Group Name</label> ';
			echo '<input type="text" class="regular-text" id="mz_group_name" name="mz_group_name" value="' . $data['groupname'] . '">';
			echo '<input type="submit" value="Save" class="button button-primary"/>';
		echo '</form>';

	}


	/**
	 * Delete the group
	 */
	public static function groups_delete_page( $groupID )
	{
		global $wpdb;

        $wpdb->delete( $wpdb->prefix . GROUPS_DB_TABLE, array( 'groupid' => $groupID ) );

        $wpdb->delete( $wpdb->prefix . USER_GROUPS_DB_TABLE, array( 'groupid' => $groupID ) );

		echo '<div class="updated"><p>';
	         _e( 'Group deleted' );
	    echo '</p></div><br/>';

		$back = $_SERVER['HTTP_REFERER'];
		echo '<a href="' . $back . '" class="button">Back</a>';
	}

}