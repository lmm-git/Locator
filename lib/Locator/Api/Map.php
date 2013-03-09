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
	 * @brief Displays a map using Mapstraction as iframe.
	 * @param int $args['pid'] PID of place.
	 * @param string $args['style'] Style of the iframe (inline style).
	 * @param string $args['class'] Class of the iframe.
	 * @param string $args['mapType'] Type of map. Currently only 'iframe' is supported.
	 * @param string $args['zoom'] Zoom of map.
	 * @return string Iframe with map
	 * @throws Zikula_Exception_Forbidden If $pid is missing.
	 */
	public function iframe($args)
	{
		if(!isset($args['pid']))
			throw new Zikula_Exception_Forbidden($this->__('$pid is missing!'));
		
		$link = ModUtil::url($this->name, 'map', 'iframe', array('pid' => $args['pid'], 'mapType' => $args['mapType'], 'zoom' => $args['zoom']), null, true);
		$linkHtml = "src=\"" . DataUtil::formatForDisplay($link) . "\"";

		return "<iframe class=\"{$args['class']}\" style=\"{$args['style']}\" {$linkHtml}></iframe>";
	}

	/**
	 * @brief Displays an inline map using Mapstraction.
	 * @param int $args['pid'] PID of place.
	 * @param string $args['style'] Style of the iframe (inline style).
	 * @param string $args['class'] Class of the iframe.
	 * @param string $args['mapType'] Type of map. Currently only 'iframe' is supported.
	 * @param string $args['zoom'] Zoom of map.
	 * @return string Iframe with map
	 * @throws Zikula_Exception_Forbidden If $pid is missing.
	 */
	public function inline($args)
	{
		$view = Zikula_View::getInstance('Locator');

		if(!isset($args['pid']))
			throw new Zikula_Exception_Forbidden($this->__('$pid is missing!'));
		
		if(!isset($args['zoom']))
			$args['zoom'] = 16;
		
		$place = $this->entityManager->find('Locator_Entity_Places', $args['pid']);

		$map = $view
			->assign('lon', $place['lon'])
			->assign('lat', $place['lat'])
			->assign('address', $place->getAddress())
			->assign('mapType', $args['mapType'])
			->assign('zoom', $args['zoom'])
			->assign('mapStyle', $args['style'])
			->assign('mapClass', $args['class'])
			->assign('rand', $args['rand']) //Used for ajax.
			->fetch('Map/Inline.tpl');

		return "<div style=\"position: relative; overflow: hidden\">$map</div>";
	}

	/**
	 * @brief Displays a map using Mapstraction via ajax.
	 * @param int $args['pid'] PID of place.
	 * @param string $args['style'] Style of the iframe (inline style).
	 * @param string $args['class'] Class of the iframe.
	 * @param string $args['mapType'] Type of map. Currently only 'iframe' is supported.
	 * @param string $args['zoom'] Zoom of map.
	 * @return string Iframe with map
	 * @throws Zikula_Exception_Forbidden If $pid is missing.
	 */
	public function ajax($args)
	{
		$view = Zikula_View::getInstance('Locator');

		if(!isset($args['pid']))
			throw new Zikula_Exception_Forbidden($this->__('$pid is missing!'));
		
		if(!isset($args['zoom']))
			$args['zoom'] = 16;
		
		$place = $this->entityManager->find('Locator_Entity_Places', $args['pid']);

		$ajaxRand = mt_rand(100000, 999999);
		$script = 
			'var request = jQuery.ajax({
				url: "' . ModUtil::url('Locator', 'map', 'ajax') . '",
				type: "GET",
				data: {rand: %RAND%, pid: ' . $args['pid'] . ', style: "' . $args['style'] . '"},
				dataType: "html"
			});
	
			request.done(function(msg) {
				jQuery("#ajaxMap_' . $ajaxRand . '").replaceWith(msg);
				LoadMap_%RAND%();
			});
	
			request.fail(function(jqXHR, textStatus) {
				alert( "Request failed: " + textStatus );
			});';

		$map = $view
			->assign('lon', $place['lon'])
			->assign('lat', $place['lat'])
			->assign('address', $place->getAddress())
			->assign('mapType', $args['mapType'])
			->assign('zoom', $args['zoom'])
			->assign('mapStyle', $args['style'])
			->assign('mapClass', $args['class'])
			->assign('mapLoadingScript', $script)
			->fetch('Map/Ajax.tpl');

		return "<div id=\"ajaxMap_$ajaxRand\" style=\"position: relative; overflow: hidden\">$map</div>";
	}

	/**
	 * @brief Get all avaiable layers.
	 */
	public function getLayers($args)
	{
		return $this->entityManager->getRepository('Locator_Entity_Layer')->findBy(array());
	}
	
	/**
	 * @brief Get a specifc provider key.
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
