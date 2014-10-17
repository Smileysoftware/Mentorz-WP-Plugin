<?php

class mz_Users{

	/**
	 * This method displays the form to add a new mentor to a group.
	 * The current mentor is pre selected in the form.
	 */
	public static function mentorsForm( $groupID )
	{
		global $wpdb;

		//Get the full list of mentors.
		$mentors = get_users( 'orderby=nicename&role=mentor' );

		//Get the mentor for this group
		$the_mentor = $wpdb->get_row('SELECT userid FROM ' . $wpdb->prefix . USER_GROUPS_DB_TABLE . ' where groupid="' . $groupID . '" and mentor="1" ');
		
		echo '<form action="" method="post">';

			echo '<select name="mentorID">';
				echo '<option>Select</option>';
				foreach ( $mentors as $mentor ) {

					if ( $the_mentor->userid == $mentor->ID ){
						echo '<option value="' . $mentor->ID . '" selected>' . $mentor->display_name . '</option>';
					} else {
						echo '<option value="' . $mentor->ID . '">' . $mentor->display_name . '</option>';
					}
					
				}
			echo '</select>';
			echo '<input type="hidden" value="' . $groupID . '" name="groupID"/>';
			echo '<input type="submit" value="Add Mentor" class="button button-primary"/>';

		echo '</form>';

		echo '<hr>';
	}



	/**
	 * This method responds to the form to add a new mentor.
	 * It first removes any old mentors as there can be only one.
	 * Then it add the new mentor.
	 */
	public static function updateMentor( $groupID, $mentorID )
	{

		global $wpdb;

		if ( $groupID && $mentorID )
		{

			//Make sure to remove all mentorz for this group
			$wpdb->delete( $wpdb->prefix . USER_GROUPS_DB_TABLE , array( 'groupid' => $groupID , 'mentor' => '1' ) );

			//Now add the new mentor to this group.
			$ins = $wpdb->query('INSERT INTO ' . $wpdb->prefix . USER_GROUPS_DB_TABLE . ' ( userid , groupid, mentor ) VALUES ("' . $mentorID . '" , "'. $groupID . '" , "1") ');

			return true;
		}

		return false;

	}



	/**
	 * This method displays the form to add a new user to a group.
	 * The list should only show users that are not already memebers of the group
	 */
	public static function usersForm( $groupID )
	{
		global $wpdb;
		$out = '';

		//Get the full list of mentors.
		$mentors = get_users( 'orderby=nicename&role=student' );

		//Get the mentor for this group
		//$the_mentor = $wpdb->get_row('SELECT userid FROM ' . $wpdb->prefix . USER_GROUPS_DB_TABLE . ' where groupid="' . $groupID . '" and mentor="1" ');
		
		$out.= '<form action="" method="post">';

			$out.= '<select name="userID">';
				$out.= '<option>Select</option>';
				foreach ( $mentors as $mentor ) {

					// if ( $the_mentor->userid == $mentor->ID ){
					// 	echo '<option value="' . $mentor->ID . '" selected>' . $mentor->display_name . '</option>';
					// } else {
						$out.= '<option value="' . $mentor->ID . '">' . $mentor->display_name . '</option>';
					// }
					
				}
			$out.= '</select>';
			$out.= '<input type="hidden" value="' . $groupID . '" name="groupID"/>';
			$out.= '<input type="submit" value="Add User" class="button button-primary"/>';

		$out.= '</form>';

		return $out;
	}




	public static function usersInGroup( $groupID )
	{
		global $wpdb;

		//Get the full list of students.
		$users = get_users( 'orderby=nicename&role=student' );

		//Get the list of users that are in this group
		$usersInGroup = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . USER_GROUPS_DB_TABLE . ' WHERE groupid = ' . $groupID . ' and mentor != 1', ARRAY_A);

		echo '<h3>Users currently in this group</h3>';
		echo '<table class="widefat">
					<thead>
					    <tr>
					        <th>Username</th>
					        <th>Email</th>
					        <th>Delete</th>
					    </tr>
					</thead>';

		//Create a new array with just the user IDs
		//$userIDs = array();
		foreach ( $usersInGroup as $userInGroup ){

			foreach ($users as $user) {

				
			
				if ( $userInGroup['userid'] == $user->ID ){
					echo '<tr><td>' . $user->display_name . '</td><td>' . $user->user_email . '</td></tr>';
				}

				
				
			}

		}

		echo '</tbody></table>';

	}


}