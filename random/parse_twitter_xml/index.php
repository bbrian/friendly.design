<?php require_once( 'xml_parser.php' ); ?>
<?php require_once( 'rss_parser.php' ); ?>

<!DOCTYPE html> 
<html lang="en" dir="ltr"> 
<head> 
 
 
	<title></title> 
 
	<!-- ||| Meta information for search engine goodness and iThings ||| --> 
 
	<meta charset="utf-8"> 
	<meta name="Description" content=""> 
	<meta id="viewport" name="viewport" content="width=960"> 
 
 
	<!-- ||| Stylesheet Linkification and IE Jiggery Pokery ||| --> 
  
	<link rel="profile" href="http://gmpg.org/xfn/11" /> 
	<link rel='index' title='' href='' /> 
 
 
	<!-- ||| Syndication and that sort of gubbins ||| --> 
 
	<link rel="pingback" href="" /> 

 
</head>

<body>

		
		<?php
			$xml_feed_location = "https://www.facebook.com/feeds/status.php?id=501209901&viewer=501209901&key=AWiL6gHTBLJ9pbFR&format=rss20";
			
			$thing = parseRSS($xml_feed_location);
			
			var_dump($thing);

		?>
	

</body>

</html>