<?php

/*

@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
@@                                                   @@
@@                                                   @@
@@                                                   @@
@@                                                   @@
@@                                                   @@
@@                                                   @@
@@                                                   @@
@@                                                   @@
@@    @@@@@@@@@@@@                                   @@
@@    @@@@@@@@@@@@                                   @@
@@    ++++#@@@++++                                   @@
@@        ;@@+         ,     .                       @@
@@        ;@@+   +@@ @@@@@ @@@@@                     @@
@@        ;@@+   +@@@@@@@@@@@@@@@                    @@
@@        ;@@+   +@@@  `@@@   @@@                    @@
@@        ;@@+   +@@    @@@   @@@                    @@
@@        ;@@+   +@@    @@@   @@@                    @@
@@        ;@@+   +@@    @@@   @@@                    @@
@@        ;@@+   +@@    @@@   @@@                    @@
@@        ;@@+   +@@    @@@   @@@                    @@
@@        ;@@+   +@@    @@@   @@@                    @@
@@        ;@@+   +@@    @@@   @@@                    @@
@@                                                   @@
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

*/

class Themeists
{

	/**
	 * Our API Key on Envato
	 *
	 * @author Richard Tape
	 * @package Themeists
	 * @since 1.0
	 */

	var $apikey = '7tuy5hnxo4guc49lo3c40tg1ehggzhwo';

	/**
	 * Our username on Envato
	 *
	 * @author Richard Tape
	 * @package Themeists
	 * @since 1.0
	 */

	var $username = 'iamfriendly';
	
	
	/**
	 * Set ourselves up
	 *
	 * @author Richard Tape
	 * @package Themeists
	 * @since 1.0
	 */
	

	function Themeists()
	{


	}/* Themeists() */


	/**
	 * Verify a user's purchase on Themeforest
	 *
	 * @author Richard Tape
	 * @package Themeists
	 * @since 1.0
	 * @param string $purchase_cose - The buyer's purchase code
	 * @return Purchase object or false
	 *
	 * Return object is something like
	 *
	 * object(stdClass)#3 (5) { ["item_name"]=> string(50) "Friendly CSS3 MegaMenu(Horiz & Vert) w/transitions" ["item_id"]=> string(6) "116430" ["created_at"]=> string(30) "Wed Dec 01 05:00:47 +1100 2010" ["buyer"]=> string(6) "jayjdk" ["licence"]=> string(15) "Regular Licence" }
	 *
	 */

	function check_purchase( $purchase_code )
	{

		require 'Envato_marketplaces.php';

		$Envato = new Envato_marketplaces();
		$Envato->set_api_key( $this->apikey );

		$verify = $Envato->verify_purchase( $this->username, $purchase_code );

		if( isset( $verify->buyer ) )
			return $verify;
		else
			return false;

	}/* check_purchase() */
	


}/* class Themeists */

?>
<!doctype html>
<html>
<head>
	<meta charset=utf-8>
	<title></title>
</head>
<body>

<?php

	$thing = new Themeists;
	$p = $thing->check_purchase( '087f46a0-ce1c-4476-bd16-b592c2437cd7' );

	var_dump( $p );

?>

</body>
</html>