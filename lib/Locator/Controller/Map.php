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
	 * @brief Displays a map using Mapstraction.
	 * @param GET $pid Place-id.
	 * @param GET $mapType Map provider to display the map for.
	 * @param GET $zoom Zoom factor.
	 * @return string Map/Iframe.tpl
	 * @throws Zikula_Exception_Forbidden If $pid is missing
	 *
	 * @note Do *not* call this function directly! Use Locator_Api_Map::Iframe() instead!
	 */
	public function Iframe()
	{
		$pid = FormUtil::getPassedValue('pid', null, 'GETPOST');
		$mapType = FormUtil::getPassedValue('mapType', 'openlayers', 'GETPOST');
		$zoom = FormUtil::getPassedValue('zoom', null, 'GETPOST');
		$style = FormUtil::getPassedValue('style', null, 'GETPOST');
		$class = FormUtil::getPassedValue('class', null, 'GETPOST');
		
		if(!isset($pid))
			throw new Zikula_Exception_Forbidden($this->__('You have to pass a $pid'));
		
		if(isset($style))
			$styleHtml = "style=\"" . $style . "\"";

		if(isset($class))
			$classHtml = "class=\"" . $class . "\"";
		
		if(!isset($zoom))
			$zoom = 16;
		
		$place = $this->entityManager->find('Locator_Entity_Places', $pid);

		return $this->view
			->assign('lon', $place['lon'])
			->assign('lat', $place['lat'])
			->assign('address', $place->getAddress())
			->assign('mapType', $mapType)
			->assign('zoom', $zoom)
			->assign('mapStyleHtml', $styleHtml)
			->assign('mapClassHtml', $classHtml)
			
			->display('Map/Iframe.tpl');
	}
}
?>
