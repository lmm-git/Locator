<?php
/**
 * Locator Geocoding bus (currently only Nominatim)
 *
 * @copyright  (c) Leonard Marschke
 * @license    GPLv3
 * @package    Locator/Geocoding
 */
class Locator_Api_Geocoding extends Zikula_AbstractApi
{
	/**
	 * @brief Geocoding with Nominatim
	 * @param string $args['mixedAddress'] Adress like 'Lindenufer 13, 13597 Berlin, Germany'
	 * @param int $args['limit'] Maximum number of places to return
	 *
	 * @return string $result['status'] false If no place found, int $numOfPlaces If place(s) found
	 * @return string $result['json'] Returned json code of nominatim (raw form)
	 * @return array  $result['array'] Returned json code of nominatim (array form)
	 * @return array  $result['array'][$i] $i = 0 means first found place, $i = 1 means second
	 * @return int    $result['array'][$i]['lat'] Latitude of place
	 * @return int    $result['array'][$i]['lon'] Longitude of place
	 * @return string $result['array'][$i]['display_name'] Display name of place
	 * @return int    $result['array'][$i]['place_id'] Place id by OpenStreetMap
	 * @return string $result['array'][$i]['license'] License of OpenStreetMap
	 * @return string $result['array'][$i]['osm_type'] see OpenStreetMap, e.g. 'way', 'node', 'relation'
	 * @return int    $result['array'][$i]['osm_id'] Id, e.g. of the 'way', 'node', 'relation'
	 * @return array  $result['array'][$i]['boundingbox'] Array with the nearest lat and lon around the place
	 * @return string $result['array'][$i]['class'] see OpenStreetMap
	 * @return string $result['array'][$i]['type'] see OpenStreetMap
	 *
	 * @see http://wiki.openstreetmap.org/
	 *
	 * @author Leonard Marschke
	 * @version 1.1
	 */
	public function Nominatim($args)
	{
		if(!isset($args['mixedAddress']))
			return LogUtil::registerError($this->__('You have to pass an address!'));
		
		
		//check for existant DB-entry
		
		$search = array('address' => $args['mixedAddress'],
		'geocoder' => 'Nominatim');
		$dbPlaces = $this->entityManager->getRepository('Locator_Entity_Places', $search)->findBy($search);
		
		//if there was a question to geocoder
		if(isset($dbPlaces[0]['id']))
		{
			foreach($dbPlaces as $place)
				$return[] = $place['geocoder_output'];
			return $return;
			
		}
		else
		{
			//build query
			$query = 'search?q=' . urlencode($args['mixedAddress']) . '&format=json';
			if(isset($args['limit']))
				$query .= '&limit='.$args['limit'];

			$resultJson = file_get_contents("http://nominatim.openstreetmap.org/" . $query);
		
			$resultJsondecode = json_decode($resultJson, true);
		
			$resultArray = array();
			$resultArray['array'] = $resultJsondecode;
			$resultArray['json'] = $resultJson;
		
			//Check for exit status
			if($resultArray['json'] == '[]')
				$resultArray['status'] = false;
			else
				$resultArray['status'] = count($resultArray['array']);
			
			//inserting DB-Entry
			foreach($resultJsondecode as $place)
			{
				$entry = new Locator_Entity_Places();
				$entry->setGeocoder('Nominatim');
				$entry->setAddress($args['mixedAddress']);
				$entry->setDisplay_name($place['display_name']);
				$entry->setLat($place['lat']);
				$entry->setLon($place['lon']);
				$entry->setGeocoder_output($place);
				$entry->setDate(date('r'));
				$this->entityManager->persist($entry);
				$this->entityManager->flush();
			}
			return $resultArray;
		}
	}
}
