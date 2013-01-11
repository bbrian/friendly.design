jQuery(document).ready(function($) {

	definegrid = function() {
		var browserWidth = $(window).width(); 
		if (browserWidth >= 1140) 
		{
	        pageUnits = 'px';
	        colUnits = 'px';
			pagewidth = 1128;
			columns = 16;
			columnwidth = 48;
			gutterwidth = 24;
			pagetopmargin = 0;
			rowheight = 24;
			gridonload = 'off';
			makehugrid();
		} 
		if (browserWidth <= 1139) 
		{
	        pageUnits = 'px';
	        colUnits = 'px';
			pagewidth = 840;
			columns = 12;
			columnwidth = 48;
			gutterwidth = 24;
			pagetopmargin = 0;
			rowheight = 24;
			gridonload = 'off';
			makehugrid();
		}
		if (browserWidth <= 959) 
		{
	        pageUnits = 'px';
	        colUnits = 'px';
			pagewidth = 696;
			columns = 10;
			columnwidth = 48;
			gutterwidth = 24;
			pagetopmargin = 0;
			rowheight = 24;
			gridonload = 'off';
			makehugrid();
		}
		if (browserWidth <= 719) 
		{
	        pageUnits = 'px';
	        colUnits = 'px';
			pagewidth = 480;
			columns = 7;
			columnwidth = 48;
			gutterwidth = 24;
			pagetopmargin = 0;
			rowheight = 24;
			gridonload = 'off';
			makehugrid();
		}
		if (browserWidth <= 479) 
		{
	        pageUnits = 'px';
	        colUnits = 'px';
			pagewidth = 336;
			columns = 5;
			columnwidth = 48;
			gutterwidth = 24;
			pagetopmargin = 0;
			rowheight = 24;
			gridonload = 'off';
			makehugrid();
		}
	}
	
	$(document).ready(function() {
		definegrid();
		setgridonload();
	});    

});