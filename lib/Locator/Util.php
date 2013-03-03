<?php

class Locator_Util
{
	public static function getProvider()
	{
		$provider = array();
		
		$provider[] = array('id' => 'cloudmade', 'displayName' => 'CloudMade', 'key' => true);
		$provider[] = array('id' => 'esri', 'displayName' => 'ESRI ArcGIS', 'key' => false);
		$provider[] = array('id' => 'google', 'displayName' => 'Google v2', 'key' => true);
		$provider[] = array('id' => 'googlev3', 'displayName' => 'Google v3', 'key' => false);
		$provider[] = array('id' => 'leaflet', 'displayName' => 'Leaflet', 'key' => false);
		$provider[] = array('id' => 'mapquest', 'displayName' => 'MapQuest', 'key' => true);
		$provider[] = array('id' => 'microsoft', 'displayName' => 'Bing Maps v6', 'key' => false);
		$provider[] = array('id' => 'microsoft7', 'displayName' => 'Bing Maps v7', 'key' => true);
		$provider[] = array('id' => 'nokia', 'displayName' => 'Nokia/Here Maps', 'key' => true);
		$provider[] = array('id' => 'openlayers', 'displayName' => 'OpenLayers', 'key' => false);
		$provider[] = array('id' => 'openmq', 'displayName' => 'MapQuest Open', 'key' => false);
		$provider[] = array('id' => 'openspace', 'displayName' => 'OS OpenSpace', 'key' => true);
		$provider[] = array('id' => 'ovi', 'displayName' => 'Ovi Maps', 'key' => false);
		$provider[] = array('id' => 'yandex', 'displayName' => 'Yandex Maps', 'key' => true);

		return $provider;
	}
	
	public static function getProviderForFormDropdown()
	{
		$allProvider = self::getProvider();
		$drodown = array();
		foreach($allProvider as $provider)
		{
			$dropdown[] = array('text' => $provider['displayName'], 'value' => $provider['id']);
		}
		return $dropdown;
	}
	
	public static function getProviderNameFromId($id)
	{
		$allProvider = self::getProvider();
		
		foreach($allProvider as $provider)
		{
			if($provider['id'] == $id)
				return $provider['displayName'];
		}
	}
}

?>
