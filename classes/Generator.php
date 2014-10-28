<?php

class mz_Generator{

    /**
     * Function to show the inbox
     */
	public static function mentorz_inbox_block()
	{
        //Wrap the whole thing in a nice section
        echo '<section class="mz_create_page">';

		//Get the users ID
		$userID = get_current_user_id();

        if ( $userID ){

            //get the current users status
            $userRoles = mz_Func::get_current_user_role();
            if ( $userRoles == 'mentor' || $userRoles == 'student'  || current_user_can( 'manage_options' ) ){

                // Get the users group
                $groupID = mz_Func::get_current_users_group( $userID );
                if ( $groupID  || current_user_can( 'manage_options' ) ){

                    echo '<section class="mz_inbox">';

                    mz_Generator::toolbar();

                    //Lets go fetch some messages
                    $messages = mz_Generator::get_messages();

                    if ( $messages ){

                        echo '
                            <table class="widefat mz_inbox_table">
                            <thead>
                                <tr>
                                    <th>Date / Time</th>';
                        if ( current_user_can( 'manage_options' ) ) {
                            echo '<th>To</th>';
                        }
                        echo '
                                    <th>From</th>
                                    <th>Subject</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Date / Time</th>';
                        if ( current_user_can( 'manage_options' ) ) {
                            echo '<th>To</th>';
                        }
                        echo '
                                    <th>From</th>
                                    <th>Subject</th>
                                    <th>View</th>
                                </tr>
                            </tfoot>';

                        foreach ( $messages as $message ) {

                            //Clean up my date
                            $stamp = date('jS M Y h:i a' , strtotime( $message['stamp'] ) );

                            //Get the info about the sender
                            $user_info = get_userdata( $message['messagefrom'] );
                            $messagefrom = $user_info->display_name;

                            //Get the info about the recipient
                            if ( current_user_can( 'manage_options' ) ) {
                                $recipient_info = get_userdata( $message['messageto'] );
                                $messageto = $recipient_info->display_name;
                            }

                            //<a href="'.get_site_url().'/'.PLUGIN_READ_PAGE.'&mz_msg='.$message['messageid'].'">View</a>
                            $showURL = add_query_arg( 'mz_msg', $message['messageid'] , get_site_url().'/'.PLUGIN_READ_PAGE. '/' );

                            echo '
                            <tbody>
                               <tr>
                                 <td>'.$stamp.'</td>
                                 ';
                            if ( current_user_can( 'manage_options' ) ) {
                                echo '<td>'.$messageto.'</td>';
                            }
                            echo '
                                 <td>'.$messagefrom.'</td>
                                 <td>'.$message['subject'].'</td>
                                 <td><a href="'.$showURL.'">View</a></td>
                               </tr>
                            </tbody>
                            ';

                        }//foreach

                        echo '</table>';

                    }  else {

                        echo '<h3>You have no messages</h3>';

                    }// if

                    echo '</section>';

                } else {

                    echo '<strong>You must be assigned to a group</strong>';

                }

            }  else {

                echo '<strong>You are not assigned a proper user</strong>';

            }  //if userroles

        } else {

            echo '<a href="'. wp_login_url( get_permalink() ).'" title="Login">You must login to view this content</a>';

        }// if userid


        echo '</section>';

	}


    /**
     * Function to display the create message page
     */
    public static function mentorz_create_block()
    {
        //Wrap the whole thing in a nice section
        echo '<section class="mz_create_page">';

        //Get the users ID
        $userID = get_current_user_id();

        if ( $userID ) {

            //get the current users status
            $userRoles = mz_Func::get_current_user_role();
            if( $userRoles == 'mentor' || $userRoles == 'student'  || current_user_can( 'manage_options' ) ) {

                // Get the users group
                $groupID = mz_Func::get_current_users_group( $userID );

                if( $groupID  || current_user_can( 'manage_options' ) ) {

                    //Lets check if the form was submitted
                    if ( $_POST ){

                        //Do a bit of validation
                        $errors = '';

                        if ( ! $_POST['mz_recipient'] ){

                            //If the role is student and there is no recipient then something went badly wrong.
                            if ( $userRoles == 'student'){
                                $errors .= '<p>No mentor defined</p>';
                            } else {
                                $errors .= '<p>You must choose a recipient</p>';
                            }

                        }
                        if ( ! $_POST['mz_subject'] ){
                            $errors .= '<p>Please enter a subject</p>';
                        }
                        if ( ! $_POST['mz_body'] ){
                            $errors .= '<p>Please enter a message</p>';
                        }

                        if ( $errors ){

                            echo mz_Generator::create_form( $userID , $groupID , $userRoles , $errors );

                        } else {

                            echo mz_Generator::create_message( $_POST['mz_recipient'] , $_POST['mz_subject'] , $_POST['mz_body'] );

                        }

                    } else {

                        echo mz_Generator::create_form( $userID , $groupID , $userRoles );

                    }



                } else {

                    echo '<strong>You must be assigned to a group</strong>';

                }

            }  else {

                echo '<strong>You are not assigned a proper user</strong>';

            }  //if userroles

        } else{

            echo '<a href="'. wp_login_url( get_permalink() ).'" title="Login">You must login to view this content</a>';

        }// if userid

        echo '</section>';

    }


    /**
     * Function
     */
    public static function mentorz_show_block()
    {

        //First check we have a message to show
        if ( $_GET['mz_msg'] ){

            $message = mz_Generator::get_message( $_GET['mz_msg'] );

            //Clean up my date
            $stamp = date('jS M Y h:i a' , strtotime( $message['stamp'] ) );

            //Get the info about the sender
            $user_info = get_userdata( $message['messagefrom'] );
            $messagefrom = $user_info->display_name;

            echo '<section class="mz_show_page">';

            echo '<p><strong>Message Sent: </strong>'.$stamp.'</p>';
            echo '<p><strong>Message From: </strong>'.$messagefrom.'</p>';
            echo '<p><strong>Subject: </strong>'.$message['subject'].'</p>';
            echo '<p><strong>Body: </strong>'.$message['body'].'</p>';

            echo '</section>';


        } else {

            echo '<h3>No message selected</h3>';

        }
    }








    /**
     * Function to show the tool bar.
     */
    private static function toolbar()
    {
        echo '<a href="'.get_site_url().'/'.PLUGIN_CREATE_PAGE.'" class="mz_button">Write a message</a>';
    }


    /**
     * Function to display the create a message form
     *
     * @param $userID
     * @param $groupID
     * @param $userRoles
     * @param null $errors
     * @return string
     */
    private static function create_form( $userID , $groupID  , $userRoles , $errors = null )
    {
        $form = '';

        if ( $errors ){
            $form .= '<div class="mz_errros">';
            $form .= $errors;
            $form .= '</div>';
        }

        $form .= '<form action="" method="post" class="mz_form mz_create_form">';

        $form .= mz_Generator::recipientList( $userID , $groupID  , $userRoles);

        $form .= '<div>';
        $form .= '<label>Please enter the subject of your message</label>';
        $form .= '<input name="mz_subject" type="text"/>';
        $form .= '</div>';

        $form .= '<div>';
        $form .= '<label>The body of your message</label>';
        $form .= '<textarea name="mz_body"></textarea>';
        $form .= '</div>';

        $form .= '<p><input type="submit" value="Send Message" class="mz_button"/></p>';
        $form .= '</form>';

        return $form;
    }


    /**
     * Function that builds the recipient list for the create message form
     *
     * @param $userID
     * @param $groupID
     * @param $userRoles
     * @return string
     */
    private static function recipientList( $userID , $groupID  , $userRoles)
    {
        global $wpdb;

        //Return a select elem
        //Determine if the user is a mentor or student or admin
        if ( $userRoles == 'mentor' ){

            $recipients = $wpdb->get_results('SELECT userid FROM ' . $wpdb->prefix . USER_GROUPS_DB_TABLE . ' WHERE  mentor != 1 AND groupid = ' . $groupID , ARRAY_A);

        } elseif ( $userRoles == 'student' ){

            $recipients =  $wpdb->get_results('SELECT userid FROM ' . $wpdb->prefix . USER_GROUPS_DB_TABLE . ' WHERE  mentor = 1 AND groupid = ' . $groupID, ARRAY_A);

        } elseif ( current_user_can( 'manage_options' ) ){

            $recipients = $wpdb->get_results('SELECT userid FROM ' . $wpdb->prefix . USER_GROUPS_DB_TABLE , ARRAY_A);

        }

        //Now either generate a select or just a text box.
        //If the user has more than one potential recipients
        //A student can only send to their mentor so use this as the deciding factor.
        if ( $userRoles == 'student' ){

            $user_info = get_userdata( $recipients[0]['userid'] );
            $displayName = $user_info->display_name;

            //Check to make sure something came back
            if ( $recipients ){
                $recipientElem = '<div>';
                $recipientElem .= '<label>Sending your message to ' . $displayName . '</label>';
                $recipientElem .= '<input name="mz_recipient" type="hidden" value="'.$recipients[0]['userid'].'"/>';
                $recipientElem .= '</div>';
            } else {
                $recipientElem = '<div>';
                $recipientElem .= '<label>It appears that no mentors are defined</label>';
                $recipientElem .= '</div>';
            }



        } else {

            $recipientElem = '<select name="mz_recipient">';
            $recipientElem .= '<option value="0">Send to everyone</option>';

            foreach ( $recipients as $recipient ) {

                $user_info = get_userdata( $recipient['userid'] );
                $displayName = $user_info->display_name;

                $recipientElem .= '<option value="'.$recipient['userid'].'">'.$displayName.'</option>';

            }

            $recipientElem .= '</select>';
        }



        return $recipientElem;

    }


    /**
     * Function to insert the message into the database
     *
     * @param $recipient
     * @param $subject
     * @param $body
     * @return string
     */
    private static function create_message( $recipient , $subject , $body ){

        global $wpdb;

        //Get the users ID
        $userID = get_current_user_id();

        $stamp = date('r');


        $wpdb->insert(
            $wpdb->prefix . MESSAGES_DB_TABLE,
            array(
                'messageto' => $recipient,
                'messagefrom' => $userID,
                'subject' => $subject,
                'body' => $body,
                'stamp' => $stamp
            )
        );

        $msgID = $wpdb->insert_id;

        if ( $msgID ){

            //TODO Notify the user via email that they have a new message
            return '<p class="mz_success">Your message was sent</p>';

        } else {

            return '<p class="mz_failure">Message sending failed</p>';

        }

    }


    private static function get_messages(){

        global $wpdb;

        //Get the users ID
        $userID = get_current_user_id();

        //IF ADMIN SHOW ALL THE MESSGAES
        if ( current_user_can( 'manage_options' ) ){

            //Fetch the message for the user
            $messages = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . MESSAGES_DB_TABLE . ' ORDER BY stamp DESC' , ARRAY_A);

        } else {

            //Fetch the message for the user
            $messages = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . MESSAGES_DB_TABLE . ' WHERE  messageto = ' . $userID . ' ORDER BY stamp DESC' , ARRAY_A);

        }


        //Return the messages array
        return $messages;

    }


    private static function get_message( $msgid ){

        global $wpdb;

        //Get the users ID
        //This is just an added bit of security
        $userID = get_current_user_id();

        //If the user is an admin then they can see all messages
        if ( current_user_can( 'manage_options' ) ){

            //Fetch the message for the user
            $message = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . MESSAGES_DB_TABLE . ' WHERE  messageid = ' . $msgid , ARRAY_A);

        } else {

            //Fetch the message for the user
            $message = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . MESSAGES_DB_TABLE . ' WHERE  messageto = ' . $userID . ' AND messageid = ' . $msgid , ARRAY_A);

        }



        //Return the messages array
        return $message;

    }

}