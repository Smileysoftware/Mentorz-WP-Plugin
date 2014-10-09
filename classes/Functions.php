<?php

class mz_Func
{

	public static function user_has_access(){

		if ( ! current_user_can( 'manage_options' ) )  {
			wp_die( __( NO_ACCESS_MESSAGE ) );
		}

	}

}