jQuery(document).ready(function() {

	if(typeof(tinyMCE) == "object"){
		tinyMCE.onAddEditor.add(function(mgr,ed){ 
			ed.onSetContent.add(function(ed){
				
				headID = ed.getWin().document.getElementsByTagName('head')[0];
				var newScript = document.createElement('script');
				newScript.type = 'text/javascript';
				newScript.src = real_path+'/inc/js/jquery.1.5.2.min.js';
				headID.appendChild(newScript);
				
				/* Slider */
				var newScript2 = document.createElement('script');
				newScript2.type = 'text/javascript';
				newScript2.src = real_path+'/inc/js/friendlyslide_tabs.js';
				headID.appendChild(newScript2);
				
				var newScript3 = document.createElement('script');
				newScript3.type = 'text/javascript';
				newScript3.src = real_path+'/inc/js/jquery.easing.min.js';
				headID.appendChild(newScript3);
				
				var newScript4 = document.createElement('script');
				newScript4.type = 'text/javascript';
				newScript4.src = real_path+'/inc/js/jquery.mousewheel.min.js';
				headID.appendChild(newScript4);
				
				var newScript5 = document.createElement('script');
				newScript5.type = 'text/javascript';
				newScript5.src = real_path+'/inc/js/friendly_tabs_for_editor.js';
				headID.appendChild(newScript5);
				
				/* Accordion */
				var newScript6 = document.createElement('script');
				newScript6.type = 'text/javascript';
				newScript6.src = real_path+'/inc/js/friendly_accordion.js';
				headID.appendChild(newScript6);
				
				var newScript7 = document.createElement('script');
				newScript7.type = 'text/javascript';
				newScript7.src = real_path+'/inc/js/friendly_accordion_for_editor.js';
				headID.appendChild(newScript7);
				
				/* Friendly Slider */
				var newScript7 = document.createElement('script');
				newScript7.type = 'text/javascript';
				newScript7.src = real_path+'/inc/js/friendly_slider.js';
				headID.appendChild(newScript7);
				
				var newScript8 = document.createElement('script');
				newScript8.type = 'text/javascript';
				newScript8.src = real_path+'/inc/js/friendly_slider_effects.js';
				headID.appendChild(newScript8);
				
				var newScript9 = document.createElement('script');
				newScript9.type = 'text/javascript';
				newScript9.src = real_path+'/inc/js/friendly_slider_for_editor.js';
				headID.appendChild(newScript9);
							
			});
		});
	}

});