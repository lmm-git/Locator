<?php
/**
 * Locator
 *
 * @copyright  (c) Leonard Marschke
 * @license    GPLv3
 * @package    Locator
 * @subpackage Version
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
		$meta['description']    = $this->__('Locator engine for geocoding and displaying maps with OpenStreetMap');
		//! module name that appears in URL
		$meta['url']            = $this->__('Locator');
		$meta['version']        = '0.0.1';
		$meta['core_min']       = '1.3.3';
		$meta['core_max']       = '1.3.99';


		// Permissions schema
		$meta['securityschema'] = array();

		// Module depedencies
		$meta['dependencies'] = array();
		return $meta;
	}
}
