<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{lang}" dir="ltr">
<head>
	{switch expr=$mapType}
		{case expr='cloudmade'}
			{modapifunc modname='Locator' type='map' func='getProviderKey' provider='cloudmade' assign='key'}
			<script type="text/javascript" src="http://tile.cloudmade.com/wml/latest/web-maps-lite.js"></script>
			<script type="text/javascript">
				var cloudmade_key = "{{$key}}";
			</script>
		{/case}
		{case expr='esri'}
			<link href="http://serverapi.arcgisonline.com/jsapi/arcgis/3.2/js/esri/css/esri.css" media="all" rel="stylesheet" type="text/css" />
			<link href="http://serverapi.arcgisonline.com/jsapi/arcgis/3.2/js/dojo/dijit/themes/claro/claro.css" media="all" rel="stylesheet" type="text/css" />
			<script src="http://serverapi.arcgisonline.com/jsapi/arcgis/?v=3.2" type="text/javascript"></script>
		{/case}
		{case expr='google'}
			{modapifunc modname='Locator' type='map' func='getProviderKey' provider='google' assign='key'}
			<script type="text/javascript" src="http://maps.google.com/maps?file=api&v=2&key=[{$key}]"></script>
		{/case}
		{case expr='googlev3'}
			<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		{/case}
		{case expr='leaflet'}
			<link href="http://leaflet.cloudmade.com/dist/leaflet.css" media="all" rel="stylesheet" type="text/css" />
			<script src="http://leaflet.cloudmade.com/dist/leaflet.js" type="text/javascript"></script>
		{/case}
		{case expr='mapquest'}
			{modapifunc modname='Locator' type='map' func='getProviderKey' provider='mapquest' assign='key'}
			<script src="http://www.mapquestapi.com/sdk/js/v7.0.s/mqa.toolkit.js?key={$key}" type="text/javascript"></script>
		{/case}
		{case expr='microsoft'}
			<script type="text/javascript" src="http://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=6.3&mkt=en-us"></script>
		{/case}
		{case expr='microsoft7'}
			{modapifunc modname='Locator' type='map' func='getProviderKey' provider='microsoft7' assign='key'}
			<script charset="UTF-8" type="text/javascript" src="http://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=7.0"></script>
			<script type="text/javascript">
				var microsoft_key = "{{$key}}";
			</script>
		{/case}
		{case expr='nokia'}
			{modapifunc modname='Locator' type='map' func='getProviderKey' provider='nokia' assign='key'}
			<meta http-equiv="X-UA-Compatible" content="IE=7; IE=EmulateIE9" />
			<script src="http://api.maps.nokia.com/2.2.1/jsl.js" type="text/javascript" charset="utf-8"></script>
			<script type="text/javascript">
				nokia.Settings.set ("appId", "{{$key.appId}}");
				nokia.Settings.set ("authenticationToken", "{{$key.authToken}}");
			</script>
		{/case}
		{case expr='openlayers'}
			<script src="http://openlayers.org/api/OpenLayers.js"></script>
		{/case}
		{case expr='openmq'}
			<script src="http://open.mapquestapi.com/sdk/js/v7.0.s/mqa.toolkit.js"></script>
		{/case}
		{case expr='openspace'}
			{modapifunc modname='Locator' type='map' func='getProviderKey' provider='openspace' assign='key'}
			<script type="text/javascript" src="http://openspace.ordnancesurvey.co.uk/osmapapi/openspace.js?key={$key}"></script>
		{/case}
		{case expr='ovi'}
			<script src="http://api.maps.ovi.com/jsl.js" type="text/javascript" charset="utf-8"></script>
		{/case}
		{case expr='yandex'}
			{modapifunc modname='Locator' type='map' func='getProviderKey' provider='yandex' assign='key'}
			<script src="http://api-maps.yandex.ru/1.1/index.xml?key={$key}" type="text/javascript"></script>
		{/case}
	{/switch}

	<script type="text/javascript" src="{$baseurl}plugins/Mapstraction/lib/vendor/mxn/mxn.js?({$mapType})"></script>
	
	<script type="text/javascript">
		window.onload = function() {
			var map = new mxn.Mapstraction('map', '{{$mapType}}'); 
			var latlon = new mxn.LatLonPoint({{$lat}}, {{$lon}});

			{{if is_numeric($zoom)}}
				map.setCenterAndZoom(latlon, {{$zoom}});
			{{/if}}

			map.addLargeControls();
			map.addMapTypeControls();

			var marker = new mxn.Marker(latlon);
			marker.setLabel("{{$address}}");
			marker.setInfoBubble("{{$address}}");
			map.addMarker(marker);
			marker.openBubble();

			{{if !is_numeric($zoom)}}
				map.autoCenterAndZoom();
			{{/if}}

			{{modapifunc modname='Locator' type='map' func='getLayers' assign='layers'}}
			{{foreach from=$layers item='layer'}}
				{{assign var='mapTypes' value=$layer->getMapTypes()}}
				{{if (empty($mapTypes) || in_array($mapType, $mapTypes)) && $layer->getActive()}}
					{{assign var='license' value=$layer->getLicense()}}
					map.addTileLayer("{{$layer->getUrl()}}", {{$layer->getOpacity()}}, '{{$layer->getName()}}' {{if !empty($license)}} + ' - {{$license}}' {{/if}}, {{$layer->getMinZoom()|default:1}}, {{$layer->getMaxZoom()|default:18}}, {{if $layer->getAlwaysOn()}}true{{else}}false{{/if}});
				{{/if}}
			{{/foreach}}
		}
	</script>
	<style type="text/css">
		html, body, #map {
			width: 100%;
			height: 100%;
			padding: 0px;
			margin: 0px;
		}
		.license {
			position: fixed;
			right: 0px;
			bottom: 0px;
			z-index: 2000;
			text-align: right;
			margin-bottom: 0px;
			margin-right: 0px;
			background-color: #efefef;
			font-family: Arial;
		}
	</style>
</head>
<body>
	<div id="map">
		{if $mapType == 'openlayers'}
			<p class="license">&copy; <a href="http://www.openstreetmap.org/copyright" alt="http://www.openstreetmap.org/copyright">OpenStreetMap</a> {gt text='contributors'}</p>
		{/if}
	</div>
</body>
</html>
