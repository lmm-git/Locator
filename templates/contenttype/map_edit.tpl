{pageaddvarblock}
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="{$baseurl}plugins/Mapstraction/lib/vendor/mxn/mxn.js?(googlev3,[geocoder])"></script>
<style type="text/css">

	#mapdiv {
		height: 400px;
		width: 100%;
	}

</style> 

<script type="text/javascript">
//<![CDATA[

	var mapstraction;
	var geocoder;
	var address = '';

	function geocode_return(geocoded_location) {
		//Remove old marker
		mapstraction.removeAllMarkers();

		// display the map centered on a latitude and longitude (Google zoom levels)
		mapstraction.setCenter(geocoded_location.point);

		addMarker(geocoded_location.point);
		
		//Add values into textareas
		document.getElementById('latitude').value = geocoded_location.point.lat.toString().substring(0, 9);
		document.getElementById('longitude').value = geocoded_location.point.lon.toString().substring(0, 9);
	}

	function user_submit(id) {
		address = document.getElementById(id).value;
		geocoder.geocode(address);
	}
	
	function changeZoom(zoom) {
		if(zoom != '')
			mapstraction.setZoom(parseInt(zoom));
	}
	
	function addMarker(latlon) {
		// create a marker positioned at a lat/lon
		marker = new mxn.Marker(latlon);
		//var address = geocoded_location.locality + ", " + geocoded_location.region;
		if(address == '')
			address = document.getElementById('address').value;
		
		marker.setInfoBubble(address);
		// display marker
		mapstraction.addMarker(marker);
		// open the marker
		marker.openBubble();
	}
//]]>
</script> 

{/pageaddvarblock}

<div id="mapdiv"></div>
<h4 class="z-formnote">{gt text='Geocoding'}</h4>
<div class="z-formrow">
	{formlabel for='address' __text='Address'}
	{formtextinput id='address' mandatory=true maxLength=255 text=$address}
	{contentlabelhelp __text='Enter your address to geocode here'}
</div>
<div class="z-formrow">
	{formlabel for='latitude' __text='Latitude'}
	{formtextinput id='latitude' mandatory=true maxLength=30 readonly=true text=$longitude}
</div>

<div class="z-formrow">
	{formlabel for='longitude' __text='Longitude'}
	{formtextinput id='longitude' mandatory=true maxLength=30 readonly=true text=$latitude}
</div>
<div class="z-buttons z-formbuttons">
	<input class="z-bt-ok z-btgreen" type="button" value="{gt text='Geocode'}" onclick="user_submit('address');"/>
</div>

<h4 class="z-formnote">{gt text='Map settings'}</h4>
<div class="z-formrow">
	{formlabel __text='Provider' for='mapType'}
	{formdropdownlist id="mapType" items=$provider mandatory=true selectedValue=$mapType group='data'}
</div>
<div class="z-formrow">
	{formlabel for='zoom' __text='Zoom level'}
	{formintinput id='zoom' group='data' mandatory=true minValue=0 maxValue=20 onkeyup='changeZoom(this.value);'}
	{contentlabelhelp __text='(from 0 for the entire world to 19 for individual buildings)'}
</div>

<div class="z-formrow">
	{formlabel for='height' __text='Height of the displayed map in pixels'}
	{formintinput id='height' group='data' mandatory=true minValue=150}
</div>

<div class="z-formrow">
	{formlabel for='text' __text='Description to be shown below the map'}
	{formtextinput id='text' maxLength=500 group='data'}
</div>
<div class="z-hide">
	{formintinput id='pid' group='data'}
</div>
{pageaddvarblock name='footer'}
<script type="text/javascript">
	// create mxn object
	mapstraction = new mxn.Mapstraction('mapdiv','googlev3');

	mapstraction.addControls({
		pan: true,
		zoom: 'small',
		map_type: true
	});

	var latlon = new mxn.LatLonPoint({{$latitude}}, {{$longitude}});

	//mapstraction.setMapType(mxn.Mapstraction.SATELLITE);
	var zoom = document.getElementById('zoom').value;
	if(zoom == '')
		zoom = 10;

	mapstraction.setCenterAndZoom(latlon, parseInt(zoom));
	mapstraction.mousePosition('position');
	
	addMarker(latlon);
	
	geocoder = new mxn.Geocoder('googlev3', geocode_return);
	
	//Event handlers
	mapstraction.click.addHandler(function(eventName, eventSource, eventArgs) {
		var latlon = eventArgs.location;
		geocoder.geocode(latlon);
	});
	
	mapstraction.changeZoom.addHandler(function(eventName, eventSource, eventArgs) {
		var zoom = mapstraction.getZoom();
		document.getElementById('zoom').value = zoom;
	});
</script>
{/pageaddvarblock}
