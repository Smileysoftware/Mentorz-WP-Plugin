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

        //If there is a mentor set then get their name and show it.
        if ( $the_mentor ){
            $display_name = mz_Func::get_users_display_name( $the_mentor->userid );
            echo '<h4>The current mentor is ' . $display_name . ' </h4>';
        } else {
            echo '<h4>There is no mentor set for this group</h4>';
        }


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
     * @param $groupID
     * @param $userID
     * @return bool
     */
    public static function updateUser( $groupID, $userID ){

        global $wpdb;

        if ( $groupID && $userID )
        {

            //Now add the new mentor to this group.
            $ins = $wpdb->query('INSERT INTO ' . $wpdb->prefix . USER_GROUPS_DB_TABLE . ' ( userid , groupid, mentor ) VALUES ("' . $userID . '" , "'. $groupID . '" , "0") ');

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

		//Get the full list of students.
		$students = get_users( 'orderby=nicename&role=student' );

		//Some way to resrtict the select to a list of people not already in the group.
		//$alreadyMembers = $wpdb->get_results('SELECT userid FROM ' . $wpdb->prefix . USER_GROUPS_DB_TABLE . ' WHERE groupid = ' . $groupID . ' and mentor != 1', ARRAY_A);
		$alreadyMembers = $wpdb->get_results('SELECT userid FROM ' . $wpdb->prefix . USER_GROUPS_DB_TABLE . ' WHERE  mentor != 1', ARRAY_A);
		foreach ($alreadyMembers as $member) {
			$already[] = $member['userid'];
		}
				
		$out.= '<form action="" method="post">';

			$out.= '<select name="userID">';
				$out.= '<option>Select</option>';
				foreach ( $students as $student ) {

                    //Check if the user is already assigned, also only run this is already is set.
					if ( ! in_array( $student->ID , $already )  && isset( $already ) ){
						$out.= '<option value="' . $student->ID . '">' . $student->display_name . '</option>';
					}
										
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
		foreach ( $usersInGroup as $userInGroup ){

			foreach ($users as $user) {

				
			
				if ( $userInGroup['userid'] == $user->ID ){
					echo '<tr><td>';
					echo $user->display_name;
					echo '</td><td>';
					echo $user->user_email;

					echo '<td style="width: 30px;">';
							echo '<a href="' . str_replace( '%7E', '~', $_SERVER['REQUEST_URI']) . '&del='.$userInGroup['userid'].'&groupID='.$groupID.'" class="">DELETE</a>';
						echo '</td>';

					echo '</tr>';
				}

				
				
			}

		}

		echo '</tbody></table>';

	}



	public static function users_delete_page( $groupID , $userID ){

		if( $groupID && $userID ){

			global $wpdb;

			//Make sure to remove all mentorz for this group
			$wpdb->delete( $wpdb->prefix . USER_GROUPS_DB_TABLE , array( 'groupid' => $groupID , 'userid' => $userID ) );

			echo '<div class="updated"><p>';
		         _e( 'User removed from group' );
		    echo '</p></div><br/>';

			$back = $_SERVER['HTTP_REFERER'];
			echo '<a href="' . $back . '" class="button">Back</a>';

		}

	}





}