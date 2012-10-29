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
	 * @author Christian Flach
	 * @version 1.0
	 */
	public function OpenStreetMap()
	{
		$lon = FormUtil::getPassedValue('lon', null, 'GET');
		$lat = FormUtil::getPassedValue('lat', null, 'GET');
		$mode = FormUtil::getPassedValue('mode', 'iframe', 'GET');
		
		if(!isset($lon) || !isset($lat))
			throw new Zikula_Exception_Forbidden($this->__('Required parameters are "lon" (Longtitude) and "lat" (Latitude)'));
		
		switch($mode)
		{
		case 'iframe':
			echo $this->view
				->assign('lon', $lon)
				->assign('lat', $lat)
				->fetch('Map/OpenStreetMap/Iframe.tpl');
			break;
		default:
			throw new Zikula_Exception_Forbidden($this->__('$mode paramter is unknown. Use "iframe" as $mode.'));
			break;
		}
		return true;
	}
}
?>
