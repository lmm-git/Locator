{modapifunc modname='Locator' type='map' func='getOSMLayers' assign='layers'}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" dir="ltr"> {*TODO Get language via variable*}
<head>
	<script type="text/javascript" src="http://www.openlayers.org/api/OpenLayers.js"></script>
	<script type="text/javascript" src="http://www.openstreetmap.org/openlayers/OpenStreetMap.js"></script>	
</head>
<body>
	<div id="map" style="height: 450px;"></div>
	{strip}
		<p style="text-align:right; font-size: 13px; font-family:Ubuntu, Arial, Times New Roman;">
			{assign var='standarLayerSetted' value=false}
			{foreach from=$layers item='layer' key='key}
				{if $layer.active == 1}
					<input type="radio" name="mapStyle" value="{$layer.id}" {if $standarLayerSetted == false}checked="checked" {/if}onclick="BuildMap('{$layer.id}');" />{$layer.name}
					{if $standarLayerSetted == false}
						{assign var='standardLayer' value=$layer.id}
						{assign var='standarLayerSetted' value=true}
					{/if}
				{/if}
			{/foreach}
			&nbsp;|&nbsp;
			{gt text="Data from"} <a href="http://www.openstreetmap.org/" style="color: #000000">OpenStreetMap</a> - {gt text="published by"} <a href="http://creativecommons.org/licenses/by-sa/2.0/" style="color: #000000">CC-BY-SA 2.0</a>
		</p>
	{/strip}
	<script type="text/javascript">
		var lat = {{$lat}};
		var lon = {{$lon}};
		var zoom = 16;
		var map;

		function BuildMap(mapStyle)
		{
			//When firstly calling this, the map variable does not exist and would cause an error.
			try
			{
				map.destroy();
			}
			catch(err)
			{ }
				
			map = new OpenLayers.Map ("map",
				{
				controls:
					[
					new OpenLayers.Control.Navigation({dragPanOptions: {enableKinetic: true} }),
					new OpenLayers.Control.PanZoomBar(),
					new OpenLayers.Control.ScaleLine({geodesic:true})
					],
				maxExtent: new OpenLayers.Bounds(-20037508.34,-20037508.34,20037508.34,20037508.34),
				maxResolution: 156543.0399,
				numZoomLevels: 19,
				units: 'm',
				projection: new OpenLayers.Projection("EPSG:900913"),
				displayProjection: new OpenLayers.Projection("EPSG:4326")
				}
			);
			
			{{foreach from=$layers item='layer' key='key}}
				{{if $layer.active == 1}}
					if (mapStyle == '{{$layer.id}}')
					{
						{{$layer.code}}
					}
				{{/if}}
			{{/foreach}}
			
			
			//Add icon to position
			layerMarkers = new OpenLayers.Layer.Markers("Markers");
			var size = new OpenLayers.Size(21,25);
			var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
			var icon = new OpenLayers.Icon('http://www.openstreetmap.org/openlayers/img/marker.png', size, offset);
			layerMarkers.addMarker(new OpenLayers.Marker(new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject()), icon));
			map.addLayer(layerMarkers);
			
			//Center map
			map.setCenter(new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject()), zoom);
		}
		BuildMap('{{$standardLayer}}'); //When loading the homepage, build map
	</script>
</body>
</html>
