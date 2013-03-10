<?php
/**
 * Locator
 *
 * @copyright  (c) Leonard Marschke
 * @license    GPLv3
 * @package    Locator/Version
 */

/**
 * Locator Version Info.
 */
class Locator_Version extends Zikula_AbstractVersion
{
	public function getMetaData()
	{
		$meta = array();
		$meta['displayname']    = $this->__('Locator');
		$meta['description']    = $this->__('Locator engine for geocoding and displaying maps using Mapstraction');
		//! module name that appears in URL
		$meta['url']            = $this->__('Locator');
		$meta['version']        = '1.0.2';
		$meta['core_min']       = '1.3.3';
		$meta['core_max']       = '1.3.5';


		// Permissions schema
		$meta['securityschema'] =  array(
				'Locator::'            => '::',
				'Locator:Layer:'       => '::',
				'Locator:ProviderKey:' => '::'
		);

		// Module depedencies
		// TODO Add mapstraction here if SystemPlugin depedencies are introduced!
		$meta['dependencies'] = array();
		return $meta;
	}
}
