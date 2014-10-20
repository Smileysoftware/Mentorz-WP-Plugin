<?php

class mz_Generator{

	public static function mentorz_inbox_block()
	{

		auth_redirect();

		//Get the users ID
		$userID = get_current_user_id();

		//get the current users status
		$userRols = mz_Func::get_current_user_role();

		// Get the users group
		$groupID = mz_Func::get_current_users_group( $userID );

echo $groupID;

		echo '
			<table class="widefat">
			<thead>
			    <tr>
			        <th>RegId</th>
			        <th>Name</th>       
			        <th>Email</th>
			    </tr>
			</thead>
			<tfoot>
			    <tr>
			    <th>RegId</th>
			    <th>Name</th>
			    <th>Email</th>
			    </tr>
			</tfoot>
			<tbody>
			   <tr>
			     <td><?php echo $regid; ?></td>
			     <td><?php echo $name; ?></td>
			     <td><?php echo $email; ?></td>
			   </tr>
			</tbody>
			</table>
		';
	}

}