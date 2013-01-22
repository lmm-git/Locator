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
	 * @param int $args['pid'] PID of place.
	 * @param string $args['style'] Style of the iframe (inline style).
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
	 *
	 * @author Christian Flach, Leonard Marschke
	 * @version 1.1
	 */
	public function OpenStreetMap($args)
	{
		if(!isset($args['pid']))
			throw new Zikula_Exception_Forbidden($this->__('There must be passed a pid'));
		
		return "<iframe style=\"" . $args['style'] . "\" src=\"" . DataUtil::formatForDisplay(ModUtil::url($this->name, 'Map', 'OpenStreetMap', array('pid' => $args['pid'], 'mode' => $args['mode']))) . "\"></iframe>";
	}
	
	/**
	 * @brief Getting all avaiable OSM-layers
	 * @author Leonard Marschke
	 * @version 1.0
	 */
	public function getOSMLayers($args)
	{
		return $this->entityManager->getRepository('Locator_Entity_OpenstreetmapLayers')->findBy(array());
	}
}
