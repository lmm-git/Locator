<?php
/**
 * Locator Map bus (currently only OpenStreetMap)
 *
 * @license    LGPLv3
 * @package    Locator
 * @subpackage Map
 */
class Locator_Api_Map extends Zikula_AbstractApi
{
	/**
	 * @brief Displays a map using OpenStreetMap.
	 * @param float $args['lon'] Longtitude.
	 * @param float $args['lat'] Latitude.
	 * @param string $args['style'] Style of the iframe.
	 * @param string $args['mode'] Type of map. Currently only 'iframe' is supported.
	 * @return string Iframe with map
	 * @throws Zikula_Exception_Forbidden If $lon or $lat are missing
	 *
     * Currently there is just one method available:
     * - iframe: Generates an iframe including the map.
     *
	 * @see http://wiki.openstreetmap.org/
	 *
	 * @todo Add other methodes then iframe
	 * @todo Add caching
	 *
	 * @author Christian Flach
	 * @version 1.0
	 */
	public function OpenStreetMap($args)
	{
		if(!isset($args['lon']) || !isset($args['lat']))
			throw new Zikula_Exception_Forbidden($this->__('Required parameters are "lon" (Longtitude) and "lat" (Latitude)'));
		
		return "<iframe style=\"".$args['style']."\" src=\"".ModUtil::url($this->name, 'Map', 'OpenStreetMap', array('lon' => $args['lon'], 'lat' => $args['lat'], 'mode' => $args['mode']))."\"></iframe>";
	}
}
