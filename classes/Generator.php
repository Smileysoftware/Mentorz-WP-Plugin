<?php

class mz_Generator{

	public static function mentorz_inbox_block()
	{

		//Get the users ID
		$userID = get_current_user_id();

        if ( $userID ){

            //get the current users status
            $userRoles = mz_Func::get_current_user_role();
            if ( $userRoles == 'mentor' || $userRoles == 'student' ){

                // Get the users group
                $groupID = mz_Func::get_current_users_group( $userID );
                if ( $groupID ){

                    echo '<section class="mz_inbox">';

                        mz_Generator::toolbar();

                        $siteURL = get_site_url();


                        //All went well, lets rock !
                        echo '
                            <table class="widefat mz_inbox_table">
                            <thead>
                                <tr>
                                    <th>Date / Time</th>
                                    <th>From</th>
                                    <th>Subject</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Date / Time</th>
                                    <th>From</th>
                                    <th>Subject</th>
                                    <th>Delete</th>
                                </tr>
                            </tfoot>
                            <tbody>
                               <tr>
                                 <td><a href="'.get_site_url().'/'.PLUGIN_READ_PAGE.'&mz_msg=12">10th Oct 14</a></td>
                                 <td>Random User</td>
                                 <td>This is the subject line</td>
                                 <td><a href="">Delete</a></td>
                               </tr>
                               <tr>
                                 <td>10th Oct 14</td>
                                 <td>Random User</td>
                                 <td>This is the subject line</td>
                                 <td><a href="">Delete</a></td>
                               </tr>
                            </tbody>
                            </table>
                        ';

                    echo '</section>';

                } else {

                    echo '<strong>You must be assigned to a group</strong>';

                }

            }  else {

                echo '<strong>You are not assigned a proper user</strong>';

            }  //if userroles

        }// if userid







	}


    public static function mentorz_create_block()
    {
        echo 'Form';
    }



    public static function mentorz_show_block()
    {
        echo 'Message view';
        echo 'ID is ' . $_GET['mz_msg'];
    }





    private function toolbar()
    {
        echo '<a href="'.get_site_url().'/'.PLUGIN_CREATE_PAGE.'" class="mz_button">Write a message</a>';
    }

}