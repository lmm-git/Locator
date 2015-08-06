<?php
/**
 * Locator
 *
 * @copyright  (c) Leonard Marschke
 * @license    GPLv3
 * @package    Locator/Installer
 */
class Locator_Installer extends Zikula_AbstractInstaller
{

	/**
	 * Provides an array containing default values for module variables (settings).
	 *
	 * @author Leonard Marschke
	 * @return array An array indexed by variable name containing the default values for those variables.
	 */
	protected function getDefaultModVars()
	{
		return array();
	}

	/**
	 * Provides standard layers for OpenStreetMap
	 *
	 * @author Leonard Marschke
	 */
	protected function setStandardLayers()
	{
		$em = $this->getService('doctrine.entitymanager');
		$layer = new Locator_Entity_OpenstreetmapLayers();
		$layer->setName($this->__('Mapnik standard layer'));
		$layer->setCode('layerMapnik = new OpenLayers.Layer.OSM.Mapnik("Mapnik");
			map.addLayer(layerMapnik);');
		$layer->setActive(true);
		$em->persist($layer);
		$em->flush();

		$layer = new Locator_Entity_OpenstreetmapLayers();
		$layer->setName($this->__('Public transport'));
		$layer->setCode('layerTiles = new OpenLayers.Layer.OSM(
					"Public Trasport",
					"http://tile.memomaps.de/tilegen/${z}/${x}/${y}.png",
					{
						numZoomLevels: 19,
						displayInLayerSwitcher:false,
						buffer:0,
						tileOptions: {crossOriginKeyword:null}
					});
				layerStops = new OpenLayers.Layer.Vector("Stops");
				map.addLayers([layerTiles,layerStops]);');
		$layer->setActive(true);
		$em->persist($layer);
		$em->flush();
		return true;
	}

	/**
	 * Initialise the Locator module.
	 *
	 * @author Leonard Marschke
	 * @return boolean: true on success / false on failure.
	 */
	public function install()
	{
		$this->setVars($this->getDefaultModVars());


		try {
			DoctrineHelper::createSchema($this->entityManager, array(
				'Locator_Entity_Places'
			));
		} catch (Exception $e) {
			echo $e;
			return false;
		}

		try {
			DoctrineHelper::createSchema($this->entityManager, array(
				'Locator_Entity_OpenstreetmapLayers'
			));
		} catch (Exception $e) {
			return false;
		}

		self::setStandardLayers();

		// Initialisation successful
		return true;
	}


	/**
	 * Upgrading the module
	 *
	 * @author Leonard Marschke
	 * @return boolean: true on success / false on error
	 * @param $oldversion
	 */
	public function upgrade($oldversion)
	{

		switch($oldversion)
		{
			case '0.0.0':
			case '0.0.1':
			case '0.0.2':
			case '0.0.3':
				try {
					DoctrineHelper::createSchema($this->entityManager, array(
						'Locator_Entity_Places'
					));
				} catch (Exception $e) {
					return false;
				}
			case '0.0.4':
				try {
					DoctrineHelper::createSchema($this->entityManager, array(
						'Locator_Entity_OpenstreetmapLayers'
					));
				} catch (Exception $e) {
					echo $e;
					System::shutdown();
					return false;
				}
				self::setStandardLayers();
		}


	return true;
	}

	/**
	 * Uninstall the module
	 *
	 * @author Leonard Marschke
	 * @return boolean: true on success / false on error
	 */
	public function uninstall()
	{
		//Remove all ModVars
		$this->delVars();

		//Remove all databases
		DoctrineHelper::dropSchema($this->entityManager, array(
			'Locator_Entity_OpenstreetmapLayers'
		));
		DoctrineHelper::dropSchema($this->entityManager, array(
			'Locator_Entity_Places'
		));

		return true;
	}
}
