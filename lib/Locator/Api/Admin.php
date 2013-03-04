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
	 */
	public function getlinks()
	{
		$links = array ();


		$addLinks = array();

		if(SecurityUtil::checkPermission('Locator:Layer:', '::', ACCESS_ADD)) {
			$addLinks = array (
				array (
					'url'   => ModUtil::url('Locator', 'admin', 'edit', array('ot' => 'layer')),
					'text'  => $this->__('Add layer')
				)
			);
		}
		
		if(SecurityUtil::checkPermission('Locator:Layer:', '::', ACCESS_MODERATE)) {
			$links[] = array (
				'url'   => ModUtil::url('Locator', 'admin', 'view', array('ot' => 'layer')),
				'text'  => $this->__('View layers'),
				'class' => 'z-icon-es-view',
				'links' => $addLinks
			);
		}

		if(SecurityUtil::checkPermission('Locator:ProviderKey:', '::', ACCESS_ADD)) {
			$addLinks = array (
				array (
					'url'   => ModUtil::url('Locator', 'admin', 'edit', array('ot' => 'layer')),
					'text'  => $this->__('Add layer')
				)
			);
		}

		if(SecurityUtil::checkPermission('Locator:ProviderKey:', '::', ACCESS_MODERATE)) {
			$links[] = array (
				'url'   => ModUtil::url('Locator', 'admin', 'view', array('ot' => 'providerKey')),
				'text'  => $this->__('View provider keys'),
				'class' => 'z-icon-es-view',
				'links' => $addLinks
			);
		}

		return $links;
	}

}

