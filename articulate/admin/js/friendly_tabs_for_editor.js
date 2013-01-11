jQuery('div#tabs_vertical').friendlySlideTabs({			   
  	orientation: 'vertical',
  	slideLength: 300,
  	contentAnim: 'slideV',
  	contentEasing: 'easeInOutExpo',
  	tabsAnimTime: 300,
  	autoHeight: true,
  	autoHeightTime: 300,
  	contentAnimTime: 600,
  	tabsScroll: false
});

jQuery('div#tabs_horizontal').friendlySlideTabs({
	// Options  			
	orientation: 'horizontal',  				
	slideLength: 694, // Width of the div#tabs_container element	
	contentAnim: 'slideH',
	contentEasing: 'easeInOutExpo',
	tabsAnimTime: 300,
	autoHeight: true,
	autoHeightTime: 300,
	contentAnimTime: 600,
	tabsScroll: false		
});