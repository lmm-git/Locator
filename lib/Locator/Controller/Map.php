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
	 * @brief Displays a map using Mapstraction as an iframe.
	 * @param GETPOST $pid Place-id.
	 * @param GETPOST $mapType Map provider to display the map for.
	 * @param GETPOST $zoom Zoom factor.
	 * @param GETPOST $style style of the map.
	 * @param GETPOST $class class of the map.
	 * @return string The rendered map.
	 * @throws Zikula_Exception_Forbidden If $pid is missing
	 *
	 * @note Do *not* call this function directly! Use Locator_Api_Map::Iframe() instead!
	 */
	public function iframe()
	{
		$pid = FormUtil::getPassedValue('pid', null, 'GETPOST');
		$mapType = FormUtil::getPassedValue('mapType', 'openlayers', 'GETPOST');
		$zoom = FormUtil::getPassedValue('zoom', 16, 'GETPOST');
		$style = FormUtil::getPassedValue('style', null, 'GETPOST');
		$class = FormUtil::getPassedValue('class', null, 'GETPOST');
		
		if(!isset($pid))
			throw new Zikula_Exception_Forbidden($this->__('You have to pass a $pid'));

		$place = $this->entityManager->find('Locator_Entity_Places', $pid);

		return $this->view
			->assign('lon', $place['lon'])
			->assign('lat', $place['lat'])
			->assign('address', $place->getAddress())
			->assign('mapType', $mapType)
			->assign('zoom', $zoom)
			->assign('mapStyle', $style)
			->assign('mapClass', $class)
			->display('Map/Iframe.tpl');
	}

	/**
	 * @brief Displays a map using Mapstraction via ajax.
	 * @param GETPOST $pid Place-id.
	 * @param GETPOST $mapType Map provider to display the map for.
	 * @param GETPOST $zoom Zoom factor.
	 * @param GETPOST $style style of the map.
	 * @param GETPOST $class class of the map.
	 * @param GETPOST $rand The random id of the map.
	 * @return string The renderd map.
	 * @throws Zikula_Exception_Forbidden If $pid is missing
	 *
	 * @note Do *not* call this function directly! Use Locator_Api_Map::Ajax() instead!
	 */
	public function ajax()
	{
		$pid = FormUtil::getPassedValue('pid', null, 'GETPOST');
		$mapType = FormUtil::getPassedValue('mapType', null, 'GETPOST');
		$zoom = FormUtil::getPassedValue('zoom', null, 'GETPOST');
		$style = FormUtil::getPassedValue('style', null, 'GETPOST');
		$class = FormUtil::getPassedValue('class', null, 'GETPOST');
		$rand = FormUtil::getPassedValue('rand', null, 'GETPOST');

		echo ModUtil::apiFunc('Locator', 'map', 'inline', array('pid' => $pid, 'mapType' => $mapType, 'zoom' => $zoom, 'style' => $style, 'class' => $class, 'rand' => $rand));
		return true;
	}
}
?>
