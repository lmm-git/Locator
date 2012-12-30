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
				'url'  => ModUtil::url('Locator', 'admin', 'layersOnOff'),
				'text' => $this->__('Show layers'),
				'class'=> 'z-icon-es-view'
			);

		if(SecurityUtil::checkPermission('Locator::', '::', ACCESS_ADMIN))
			$links[] = array (
				'url'  => ModUtil::url('Locator', 'admin', 'AddOpenStreetMapLayer'),
				'text' => $this->__('Add OpenStreetMap layer'),
				'class'=> 'z-icon-es-new'
			);

		return $links;
	}

}

