<?php
/**
 * Locator Geocoding bus (currently only Nominatim)
 *
 * @copyright  (c) Leonard Marschke
 * @license    GPLv3
 * @package    Locator
 * @subpackage Geocoding
 */

class Locator_Api_Geocoding extends Zikula_AbstractApi
{
	/**
	 * @brief Geocoding with Nominatim
	 * @return array $result['array'][$i] Array of $result['json']
	 * @return int $result['array'][$i]['place_id'] Place id by OpenStreetMap
	 * @return string $result['array'][$i]['license'] License of OpenStreetMap
	 * @return string $result['array'][$i]['osm_type'] see OpenStreetMap
	 * @return int $result['array'][$i]['osm_id'] id of the osm
	 * @return array $result['array'][$i]['boundingbox'] Array with the box of place; see OpenStreetMap
	 * @return int $result['array'][$i]['lat'] latitude of place
	 * @return int $result['array'][$i]['lon'] longitude of place
	 * @return string $result['array'][$i]['display_name'] display name of place
	 * @return string $result['array'][$i]['class'] see OpenStreetMap
	 * @return string $result['array'][$i]['type'] see OpenStreetMap
	 * @return string $result['json'] the returned json code from the nominatim machine
	 * @return string $result['status'] this can be found, not found and not exact for more than one place
	 * @param $args['mixedAddress'] mixed address like 'Lindenufer 13, 13597 Berlin, Germany]
	 *
	 * No return, just a redirection to viewevents()array
	 *
	 * @author Leonard Marschke
	 * @version 1.0
	 */
	public function Nominatim($args)
	{
		if(!$args['mixedAddress'])
			return LogUtil::registerError($this->__('You have to pass a address!'));
		
		//build query
		$query = 'search?q=' . urlencode($args['mixedAddress']) . '&format=json';
		
		$resultJson = file_get_contents("http://nominatim.openstreetmap.org/" . $query);
		
		$resultJsondecode = json_decode($resultJson, true);
		
		$resultArray = array();
		$resultArray['array'] = $resultJsondecode;
		$resultArray['json'] = $resultJson;
		
		//Check for exit status
		if($resultArray['json'] == '[]')
			$resultArray['status'] = 'not found';
		elseif($resultArray['array'][1])
			$resultArray['status'] = 'not exact';
		else
			$resultArray['status'] = 'found';
		
		return $resultArray;
	}
}
