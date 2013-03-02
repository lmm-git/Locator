<?php
/**
 * Locator Map Controller (currently only OpenStreetMap)
 *
 * @license    LGPLv3
 * @package    Locator
 * @subpackage Map_Controller
 */
class Locator_Controller_Map extends Zikula_AbstractController
{
	/**
	 * @brief Displays a map using OpenStreetMap.
	 * @param GET $lon Longtitude.
	 * @param GET $lat Latitude.
	 * @param GET $mode Type of map. Currently only 'iframe' is supported.
	 * @return string Map/OpenStreetMap/Iframe.tpl
	 * @throws Zikula_Exception_Forbidden If $lon or $lat are missing
	 *
     * Currently there is just one method available:
     * - iframe: Generates an iframe including the map.
     *
	 * @see http://wiki.openstreetmap.org/
	 *
	 * @todo Add other methodes then iframe
	 * @todo Add caching
	 * @note Do *not* call this function directly! Use Locator_Api_Map::OpenStreetMap() instead!
	 *
	 * @author Christian Flach, Leonard Marschke
	 * @version 1.0
	 */
	public function OpenStreetMap()
	{
		$pid = FormUtil::getPassedValue('pid', null, 'GET');
		$mode = FormUtil::getPassedValue('mode', 'iframe', 'GET');
		
		if($pid == null)
			throw new Zikula_Exception_Forbidden($this->__('There must be passed a pid'));
		
		$place = $this->entityManager->find('Locator_Entity_Places', $pid);
		
		switch($mode)
		{
		case 'iframe':
			echo $this->view
				->assign('lon', $place['lon'])
				->assign('lat', $place['lat'])
				->fetch('Map/OpenStreetMap/Iframe.tpl');
			System::shutdown();
			return true;
			break;
		default:
			throw new Zikula_Exception_Forbidden($this->__('$mode paramter is unknown. Use "iframe" as $mode.'));
			break;
		}
		return false;
	}
	
	public function Iframe()
	{
		$pid = FormUtil::getPassedValue('pid', null, 'GETPOST');
		$mapType = FormUtil::getPassedValue('mapType', 'openlayers', 'GETPOST');
		$zoom = FormUtil::getPassedValue('zoom', null, 'GETPOST');
		
		if(!isset($pid))
			throw new Zikula_Exception_Forbidden($this->__('You have to pass a $pid'));
		
		if($mapType == 'openlayers' && !isset($zoom))
			$zoom = 13;
		
		$place = $this->entityManager->find('Locator_Entity_Places', $pid);

		echo $this->view
			->assign('lon', $place['lon'])
			->assign('lat', $place['lat'])
			->assign('mapType', $mapType)
			->assign('zoom', $zoom)
			->assign('address', $place->getAddress())
			->fetch('Map/Iframe.tpl');
		return true;
	}
}
?>
