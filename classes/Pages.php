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

	}

	public static function installation_page()
	{
		mz_Func::user_has_access();

		echo '

			<div class="wrap">

				<h2>Mentorz - Installation Guidelines</h2>
				<p>Installation.</p>

				<h3>Users</h3>
				<p>The system uses two types of user.</p>
				<ol>
					<li>Mentor</li>
					<li>Student</li>
				</ol>

				<p>When managing users in the WordPress User module ensure that users have the proper role.</p>


				<h3>Tags</h3>

				<p>The following tags are designed to be placed inside the WordPress page content area</p>

				<p><input value="[mentorz_inbox]"> can be placed in the page to generate the inbox view</p>

				<p><input value="[mentorz_create]"> can be placed in the page to generate the message creation form</p>

			</div>

		';
	}

}