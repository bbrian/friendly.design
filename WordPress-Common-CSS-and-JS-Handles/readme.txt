WordPress allows theme and plugin developers to 'enqueue' scripts and styles meaning only 1 copy of that file is ever loaded. This is brilliant. However, it falls down if 2 different developers use the same file but register them with a different 'handle'.

I'm proposing to have a common list of popular CSS/JavaScript files here with handles which we can all use in our themes and plugins - that means our end users wont be downloading files unnecessarily. (As an aside, you might learn of some new cool CSS or JS package you didn't know about before :) )

I suggest we prefix each name with css- or js-. The resaon for this is it'll make it rather obvious as to what it is we're enqueing, make it easier view in source and several popular files use the same filename for their js and css files (if they have both).

Here's a few to kick us off;

<table class="common_js_css table">
	
	<thead>
		<tr>
			<th>Name of script</th>
			<th>File name</th>
			<th>Proposed Handle</th>
		</tr>
	</thead>

    <tr>
        <td rowspan="3">Nivo Slider</td>
        <td>nivo-slider.css</td>
        <td>css-nivo-slider</td>
    </tr>

    <tr>
    	<td>jquery.nivo.slider.js</td>
    	<td>js-nivo-slider</td>
    </tr>

	<tr class="bottom_row">
    	<td>jquery.nivo.slider.pack.js</td>
    	<td>js-nivo-slider-pack</td>
    </tr>

    <tr>
        <td rowspan="2">Selectivizr</td>
        <td>selectivizr.js</td>
        <td>js-selectivizr</td>
    </tr>

    <tr class="bottom_row">
    	<td>selectivizr-min.js</td>
    	<td>js-selectivizr-min</td>
    </tr>

    <tr>
        <td rowspan="12">Twitter Bootstrap</td>
        <td>bootstrap-alert.js</td>
        <td>js-bootstrap-alert</td>
    </tr>

    <tr class="">
    	<td>bootstrap-button.js</td>
    	<td>js-bootstrap-button</td>
    </tr>

    <tr class="">
    	<td>bootstrap-carousel.js</td>
    	<td>js-bootstrap-carousel</td>
    </tr>

    <tr class="">
    	<td>bootstrap-collapse.js</td>
    	<td>js-bootstrap-collapse</td>
    </tr>

    <tr class="">
    	<td>bootstrap-dropdown.js</td>
    	<td>js-bootstrap-dropdown</td>
    </tr>

    <tr class="">
    	<td>bootstrap-modal.js</td>
    	<td>js-bootstrap-modal</td>
    </tr>

    <tr class="">
    	<td>bootstrap-popover.js</td>
    	<td>js-bootstrap-popover</td>
    </tr>

    <tr class="">
    	<td>bootstrap-scrollspy.js</td>
    	<td>js-bootstrap-scrollspy</td>
    </tr>

    <tr class="">
    	<td>bootstrap-tab.js</td>
    	<td>js-bootstrap-tab</td>
    </tr>

    <tr class="">
    	<td>bootstrap-tooltip.js</td>
    	<td>js-bootstrap-tooltip</td>
    </tr>

    <tr class="">
    	<td>bootstrap-transition.js</td>
    	<td>js-bootstrap-transition</td>
    </tr>

    <tr class="bottom_row">
    	<td>bootstrap-typehead.js</td>
    	<td>js-bootstrap-typehead</td>
    </tr>

    <tr>
        <td rowspan="2">Impress.js</td>
        <td>impress.js</td>
        <td>js-impress</td>
    </tr>

    <tr class="bottom_row">
    	<td>impress-min.js</td>
    	<td>js-impress-min</td>
    </tr>

    <tr>
        <td rowspan="2">Modernizr</td>
        <td>modernizr.js</td>
        <td>js-modernizr</td>
    </tr>

    <tr class="bottom_row">
    	<td>grunt.js</td>
    	<td>js-grunt</td>
    </tr>

    <tr>
        <td rowspan="2">Zurb Foundation</td>
        <td>foundation.js</td>
        <td>js-foundation</td>
    </tr>

    <tr class="bottom_row">
    	<td>selectivizr-min.js</td>
    	<td>js-selectivizr-min</td>
    </tr>

</table>