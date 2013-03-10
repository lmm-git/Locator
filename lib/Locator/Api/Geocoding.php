<?php
/**
 * Locator Geocoding bus (currently only Nominatim)
 *
 * @copyright  (c) Locator Team
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
	 * @return array  $result['array'] Returned json code of nominatim (array form)
	 * @return array  $result['array'][$i] $i = 0 means first found place, $i = 1 means second...
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
	 * @return string $result['array'][$i]['pid'] Place id of Locator. You must pass this id in case of display location.
	 *
	 * @see http://wiki.openstreetmap.org/
	 *
	 * @author Leonard Marschke
	 * @version 1.2
	 */
	public function Nominatim($args)
	{
		if(!isset($args['mixedAddress']))
			return LogUtil::registerError($this->__('You have to pass an address!'));
		
		
		//check for existant DB-entry
		
		$search = array('address' => $args['mixedAddress'],
		'geocoder' => 'Nominatim');
		$dbPlaces = $this->entityManager->getRepository('Locator_Entity_Places', $search)->findBy($search);
		
		if(!empty($dbPlaces))
		{
			$id = $dbPlaces[0]->getId();
			$date = $dbPlaces[0]->getDate()->format('U');
			//if there was a question to geocoder and it is not too long ago.
			if(isset($id) && time() < $date + (60*60*24*30))
			{
				$return = array();
				$rerurn['array'] = array();
				foreach($dbPlaces as $place)
				{
					$array = $place->getGeocoder_Output();
					$array['pid'] = $place->getId();
					$return['array'][] = $array;
				}
				$return['status'] = count($return['array']);
				return $return;
			}
		}
		else
		{
			//build query
			$query = 'search?q=' . urlencode($args['mixedAddress']) . '&format=json';
			if(isset($args['limit']))
				$query .= '&limit=' . $args['limit'];
			$email = $this->getVar('nominatim_mail_address');
			if(!empty($email))
				$query .= '&email=' . $email;

			$resultJson = file_get_contents("http://nominatim.openstreetmap.org/" . $query);
		
			$resultJsondecode = json_decode($resultJson, true);
		
			$resultArray = array();
			$resultArray['array'] = $resultJsondecode;
		
			//Check for exit status
			if($resultArray['json'] == '[]')
				$resultArray['status'] = false;
			else
				$resultArray['status'] = count($resultArray['array']);
			
			//inserting DB-Entry
			foreach($resultJsondecode as $key => $place)
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
				$resultArray['array'][$key]['pid'] = $entry->getId();
			}
			return $resultArray;
		}
	}
	
	public function addPlace($args)
	{
		$search = array('address' => $args['address'],
						'geocoder' => $args['geocoder']);
		$dbPlaces = $this->entityManager->getRepository('Locator_Entity_Places', $search)->findBy($search);

		if(!empty($dbPlaces))
		{
			$id = $dbPlaces[0]->getId();
			$date = $dbPlaces[0]->getDate()->format('U');
			//if there was a question to geocoder and it is not too long ago.
			if(isset($id) && time() < $date + (60*60*24*30))
				return $id;
		}

		$entry = new Locator_Entity_Places();
		$entry->setGeocoder($args['geocoder']);
		$entry->setAddress($args['address']);
		$entry->setDisplay_name($args['address']);
		$entry->setLat($args['lat']);
		$entry->setLon($args['lon']);
		$entry->setGeocoder_output(isset($args['geocoder_output']) ? $args['geocoder_output'] : array());
		$entry->setDate(isset($args['date']) ? $args['date'] : date('r'));
		$em = $this->getService('doctrine.entitymanager');
		$em->persist($entry);
		$em->flush();
		
		return $entry->getId();
	}
	
	public function getPlaceById($args)
	{
		$place = $this->entityManager->find('Locator_Entity_Places', $args['pid']);
		return $place;
	}
}
