<?php

class mz_Pages{

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



	public static function groups_page()
	{

		if ( $_POST ){

			//Do a bit of validation
			if ( ! $_POST['mz_group_name'] ){
				$error = 'You must fill in the form';
				Self::newGroupForm( $error );
			} else {
				//Make the update
				$mz_group_name = esc_sql( stripslashes( $_POST['mz_group_name'] ) );
				global $wpdb;
				$ins = $wpdb->query('INSERT INTO ' . $wpdb->prefix . GROUPS_DB_TABLE . ' ( groupname , groupactive ) VALUES ("' . $mz_group_name . '" , "0") ');
			}

		} else {
			echo '<div class="wrap">';
			echo '<h2>Mentorz - Group Adminstration</h2>';

			Self::newGroupForm();

			global $wpdb;
			$results = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . GROUPS_DB_TABLE , ARRAY_A);
	
			if(count($results)){
				
				echo '<p>&nbsp;</p>';
				echo '<table cellspacing="0" class="widefat">';
				echo '<thead>';
					echo '<tr>';
						echo '<th class="column-title"><span>Group Name</span></th>';
						echo '<th class="column-title">Group Active</th>';
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
						echo '<tr>';
					echo '</tbody>';


				}

			} else {
				echo '<h3>There are no groups yet</h3>';
				
			}

			echo '</div>';

		} //if post

	} //func



	private static function newGroupForm( $error = null)
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

}