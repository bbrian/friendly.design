<!DOCTYPE html>

<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>

	<meta charset="utf-8" />

	<!-- Set the viewport width to device width for mobile -->
	<meta name="viewport" content="width=device-width" />

	<title>Price Slider</title>
  
	<link rel="stylesheet" href="_a/css/nouislider.css">

	<!-- IE Fix for HTML5 Tags -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

</head>

<body>

	<div id="wpsc_price_range-2" class="widget widget_wpsc_price_range">
	<h3 class="widget-title"><span>Price Range</span></h3>
	<ul>
	<li><a href="http://earth.local.significantlybetter/shop/?range=-29">Under <span class="pricedisplay">£30.00</span></a></li>
	<li><a href="http://earth.local.significantlybetter/shop/?range=30-39"><span class="pricedisplay">£30.00</span> - <span class="pricedisplay">£39.00</span></a></li>
	<li><a href="http://earth.local.significantlybetter/shop/?range=40-59"><span class="pricedisplay">£40.00</span> - <span class="pricedisplay">£59.00</span></a></li>
	<li><a href="http://earth.local.significantlybetter/shop/?range=60-99"><span class="pricedisplay">£60.00</span> - <span class="pricedisplay">£99.00</span></a></li>
	<li><a href="http://earth.local.significantlybetter/shop/?range=100-239"><span class="pricedisplay">£100.00</span> - <span class="pricedisplay">£239.00</span></a></li>
	<li><a href="http://earth.local.significantlybetter/shop/?range=290-">Over <span class="pricedisplay">£240.00</span></a></li>
	<li><a href="http://earth.local.significantlybetter/shop/?range=all">Show All</a></li></ul></div>

	<script src="_a/js/jquery.js"></script>
	<script src="_a/js/jquery.nouislider.min.js"></script>
	
	<script>
	
		jQuery(document).ready(function($) {

			/* ======================================================================================= */

			/* function round to 2dp */
			function roundNumber(num, dec) {
				var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
				return result;
			}

			/* For info panel */
			if( $('.widget_wpsc_price_range').length !== 0 ){
			
				//Start with an empty array.
				var prices = new Array();
			
				//First we need to get the max values out of the markup. Parse the penultimate url
				$( '.widget_wpsc_price_range ul li a' ).each(function(){
					var this_url = $(this).attr('href');
					var split_url = this_url.split("?range=");
					var after_range = split_url[1].split("-");
					var this_price = after_range[0];
					
					if( this_price != 'all' ){
						prices.push(this_price);
					}
					
				});
				
				var largest = Math.max.apply(Math, prices);

				
				//Then we append the markup we need for the slider
				$('.widget_wpsc_price_range').after('<div class="price_slider sliderbar"></div><span class="standard">From:</span> <span id="lowValue">0</span>&nbsp; &nbsp;<span class="standard">To: </span> <span id="highValue"></span>');
				
				//Then we hide the list
				$( '.widget_wpsc_price_range ul' ).hide();
				
				//Then we run the noUiSlider
				$(".price_slider").noUiSlider("init", { startMin: 0, startMax: largest,scale: [0, largest], tracker:

					function(){
					
						$("#lowValue").text(
							roundNumber( $(".price_slider").noUiSlider("getValue")[0], 2 )
						);
						
						$("#highValue").text(
							roundNumber( $(".price_slider").noUiSlider("getValue", {point: "upper"}), 2 )
						);
				
					}
				
				});
			
				//Finally we just need to output the To val initially
				$("#highValue").text( largest );
			
			}
			
		});
	
	</script>

</body>

</html>