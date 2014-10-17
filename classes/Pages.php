<?php

class mz_Pages{


	/**
	 * Displays the main page for the plugin
	 */
	public static function main_page()
	{

		mz_Func::user_has_access();

		echo '<div class="wrap">';
		echo '<div id="icon-edit-comments" class="icon32"></div>';

		echo '<h2>Mentorz</h2>';

		echo '<p>Here is where the form would go if I actually had options.</p>';
		echo '</div>';

		echo plugins_url();

	}


	/**
	 * Displays the installation page
	 */
	public static function installation_page()
	{
		mz_Func::user_has_access();

		echo '

			<div class="wrap">

				<h2>Mentorz - Installation Guidelines</h2>
				<p>Installation.</p>
				<p>Create three pages.</p>
				<ol>
					<li>/inbox</li>
					<li>/inbox/create</li>
					<li>/inbox/show</li>
				</ol>

				<h3>Users</h3>
				<p>The system uses two types of user.</p>
				<ol>
					<li>Mentor</li>
					<li>Student</li>
				</ol>

				<p>When managing users in the WordPress User module ensure that users have the proper role.</p>


				<h3>Tags</h3>

				<p>The following tags are designed to be placed inside the WordPress page content area</p>

				<p><input value="[mentorz_inbox]"> can be placed in the page to generate the inbox view. Pages must be /inbox</p>

				<p><input value="[mentorz_create]"> can be placed in the page to generate the message creation form. Page must be /inbox/create</p>

				<p><input value="[mentorz_show]"> can be placed in the page to generate the message view. Page must be /inbox/show</p>

			</div>

		';
	}



	/**
	 * Displays the groups page and handles post, edit and delete
	 */
	public static function groups_page()
	{

		//If the form was submitted
		if ( $_POST ){

			//Do a bit of validation
			if ( ! $_POST['mz_group_name'] ){
				$error = 'You must fill in the form';
				mz_Groups::newGroupForm( $error );
			} else {
				//Make the update
				$mz_group_name = esc_sql( stripslashes( $_POST['mz_group_name'] ) );
				global $wpdb;
				$ins = $wpdb->query('INSERT INTO ' . $wpdb->prefix . GROUPS_DB_TABLE . ' ( groupname , groupactive ) VALUES ("' . $mz_group_name . '" , "0") ');
			}

		}


		echo '<div class="wrap">';
		echo '<h2>Mentorz - Group Administration</h2>';

		//Generate the form
		mz_Groups::newGroupForm();

		global $wpdb;
		$results = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . GROUPS_DB_TABLE , ARRAY_A);

		if(count($results)){
			
			echo '<p>&nbsp;</p>';
			echo '<table cellspacing="0" class="widefat">';
			echo '<thead>';
				echo '<tr>';
					echo '<th class="column-title"><span>Group Name</span></th>';
					echo '<th class="column-title">Group Active</th>';
					echo '<th class="column-title">Edit</th>';
					echo '<th class="column-title">Delete</th>';
				echo '</tr>';
			echo '</thead>';

			foreach ($results as $key => $value) {

				//Clean up the status
				$status = $value['groupactive'];
				if ( $status == 0 ){
					$status = "Inactive";
				} elseif ( $status == 1 ){
					$status = "Active";
				}

				echo '<tbody>';
					echo '<tr>';
						echo '<td>' . $value['groupname'] . '</td>';
						echo '<td>' . $status . '</td>';
						echo '<td style="width: 30px;">';
							echo '<a href="' . str_replace( '%7E', '~', $_SERVER['REQUEST_URI']) . '&edit='.$value['groupid'].'" class="">EDIT</a>';
						echo '</td>';
						echo '<td style="width: 30px;">';
							echo '<a href="' . str_replace( '%7E', '~', $_SERVER['REQUEST_URI']) . '&del='.$value['groupid'].'" class="">DELETE</a>';
						echo '</td>';
					echo '<tr>';
				echo '</tbody>';


			}//fe

		} else {

			echo '<h3>There are no groups yet</h3>';
			
		}

		echo '</div>';

	} //func






	







	public static function users_page()
	{
		echo '<div class="wrap">';
		echo '<h2>Mentorz - Users Administration</h2>';

		//Detect new mentor being set
		if ( isset( $_POST['mentorID'] ) ){
			//A new mentor has been setup
			if ( mz_Users::updateMentor( $_POST['groupID'] , $_POST['mentorID'] ) ){
				echo '<div class="updated"><p>';
			         _e( 'Mentor added to group' );
			    echo '</p></div><br/>';
			} else {
				echo '<div class="error"><p>';
			         _e( 'Mentor not added to group' );
			    echo '</p></div><br/>';
			}
		}

		//Get a list of groups so I can display an accordion
		global $wpdb;
		$results = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . GROUPS_DB_TABLE , ARRAY_A );

		if ( $results ){

			echo '<ul class="mz_accordion">';

			foreach ($results as $result) {

				echo '<li class="mz_accordion_group_' . $result['groupid'] . '">';

					echo '<h3>' . $result['groupname'] . '</h3>';

					echo '<div class="mz_accordion_item mz_accordion_group_' . $result['groupid'] . '_inner">';

						mz_Users::mentorsForm( $result['groupid'] );

						$usersForm = mz_Users::usersForm( $result['groupid'] );

						echo $usersForm;

							//Generate a list of all the users in this group
						mz_Users::usersInGroup( $result['groupid'] );

						echo $usersForm;

						echo '<hr/>';


					echo '</div>';

					

				echo '</li>';

			}

			echo '</ul>';

		} else {
			echo '<h3>There are no groups yet</h3>';
			echo '<p>Please add groups in the Groups Administration page</p>';
		}
		

		

		echo '</div>';
	}



	




}