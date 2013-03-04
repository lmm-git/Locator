<?php
/**
 * Locator Map bus
 *
 * @copyright  (c) Locator Team
 * @license    GPLv3
 * @package    Installer
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
	 */
	public function Iframe($args)
	{
		if(!isset($args['pid']))
			throw new Zikula_Exception_Forbidden($this->__('$pid is missing!'));

		if(isset($args['style']))
			$styleHtml = "style=\"" . $args['style'] . "\"";

		if(isset($args['class']))
			$classHtml = "class=\"" . $args['class'] . "\"";
		
		$link = ModUtil::url($this->name, 'map', 'Iframe', array('pid' => $args['pid'], 'mapType' => $args['mapType'], 'zoom' => $args['zoom']), null, true);
		$linkHtml = "src=\"" . DataUtil::formatForDisplay($link) . "\"";

		return "<iframe {$classHtml} {$styleHtml} {$linkHtml}></iframe>";
	}

	public function Inline($args)
	{
		$view = Zikula_View::getInstance('Locator');

		if(!isset($args['pid']))
			throw new Zikula_Exception_Forbidden($this->__('$pid is missing!'));
		
		if(isset($args['style']))
			$styleHtml = "style=\"" . $args['style'] . "\"";

		if(isset($args['class']))
			$classHtml = "class=\"" . $args['class'] . "\"";
		
		if(!isset($args['zoom']))
			$args['zoom'] = 16;
		
		$place = $this->entityManager->find('Locator_Entity_Places', $args['pid']);

		$map = $view
			->assign('lon', $place['lon'])
			->assign('lat', $place['lat'])
			->assign('address', $place->getAddress())
			->assign('mapType', $args['mapType'])
			->assign('zoom', $args['zoom'])
			->assign('mapStyleHtml', $styleHtml)
			->assign('mapClassHtml', $classHtml)
			->fetch('Map/Inline.tpl');

		return "<div style=\"position: relative\">$map</div>";
	}

	/**
	 * @brief Get all avaiable layers
	 */
	public function getLayers($args)
	{
		return $this->entityManager->getRepository('Locator_Entity_Layer')->findBy(array());
	}
	
	/**
	 * @brief Get a specifc provider key
	 */
	public function getProviderKey($args)
	{
		if(!isset($args['provider']))
			throw new Zikula_Exception_Forbidden($this->__('$provider is missing!'));

		$em = $this->getService('doctrine.entitymanager');
		$qb = $em->createQueryBuilder();
		$qb->select('p')
		   ->from('Locator_Entity_ProviderKey', 'p')
		   ->where('p.mapType = :mapType')
		   ->setParameter('mapType', $args['provider']);
		$key = $qb->getQuery()->getArrayResult();
		
		if($args['provider'] == 'nokia')
			return array('appId' => $key[0]['providerKey'], 'authToken' => $key[0]['providerKe2']);

		return $key[0]['providerKey'];
	}
}
