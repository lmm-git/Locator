<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{lang}" dir="ltr">
<head>
	{LocatorRandom assign='rand'}
	{include file='Map/RawHead.tpl'}
	{*Load map. The javascript in RawHead cannot be used, because 'pageaddvarblock' wouldn't work.*}
	<script type="text/javascript">
		{{if !isset($mapLoadingScript)}}
			window.onload = function() {
				LoadMap_{{$rand}}();
			}
		{{else}}
			{{LocatorReplaceRand javascript=$mapLoadingScript}}
		{{/if}}
	</script>
	<style type="text/css">
		html, body, #map_{{$rand}} {
			width: 100%;
			height: 100%;
			padding: 0px;
			margin: 0px;
		}
		body {
			font: 76% Verdana, Tahoma, Arial, sans-serif;
		}
		a:hover {
			color: #2a5a8a;
			text-decoration: none;
		}
		a {
			color: #467aa7;
			text-decoration: none;
		}
	</style>
</head>
<body>
	{include file='Map/RawBody.tpl'}
</body>
</html>
