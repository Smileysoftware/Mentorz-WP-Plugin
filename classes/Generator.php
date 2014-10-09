<?php

class mz_Generator{

	public static function mentorz_inbox_block()
	{
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