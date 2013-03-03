<?php
/**
 * Locator Adminapi bus
 *
 * @license    GPLv3
 * @package    Locator/Adminapi
 */
class Locator_Api_Admin extends Zikula_AbstractApi
{
	/**
	 * Get admin panel links.
	 *
	 *
	 * @author Leonard Marschke
	 * @return array Array of admin links.
	 */
	public function getlinks()
	{
		$links = array ();

		if(SecurityUtil::checkPermission('Locator::', '::', ACCESS_ADMIN))
			$links[] = array (
				'url'  => ModUtil::url('Locator', 'admin', 'toggleLayers'),
				'text' => $this->__('Show layers'),
				'class'=> 'z-icon-es-view'
			);

		if(SecurityUtil::checkPermission('Locator::', '::', ACCESS_ADMIN))
			$links[] = array (
				'url'  => ModUtil::url('Locator', 'admin', 'addLayer'),
				'text' => $this->__('Add OpenStreetMap layer'),
				'class'=> 'z-icon-es-new'
			);

		if(SecurityUtil::checkPermission('Locator::', '::', ACCESS_ADMIN))
			$links[] = array (
				'url'  => ModUtil::url('Locator', 'admin', 'view', array('ot' => 'providerKey')),
				'text' => $this->__('Manage keys'),
				'class'=> 'z-icon-es-preview'
			);

		return $links;
	}

}

