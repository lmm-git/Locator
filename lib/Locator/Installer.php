<?php
/**
 * Locator
 *
 * @copyright  (c) Locator Team
 * @license    GPLv3
 * @package    Installer
 */
class Locator_Installer extends Zikula_AbstractInstaller
{
	/**
	 * Adds default layers to database.
	 */
	private function addDefaultLayers()
	{
		$layers = array();
		
		$layers[] = array(
				'name'     => $this->__('Public transport map'),
				'mapTypes' => 'openlayers',
				'url'      => 'http://tile.memomaps.de/tilegen/${z}/${x}/${y}.png',
				'license'  => '&copy; by MeMoMaps',
				'minZoom'  => 1,
				'maxZoom'  => 18,
				'opacity'  => 1,
				'alwaysOn' => false,
				'active'   => true
		);

		$em = $this->getService('doctrine.entitymanager');

		foreach($layers as $layer)
		{
			$layerEntity = new Locator_Entity_Layer();
			$layerEntity->merge($layer);
			
			$em->persist($layerEntity);
			$em->flush();
		}
		return true;
	}


	/**
	 * Initialise the Locator module.
	 *
	 * @return boolean: true on success / false on failure.
	 */
	public function install()
	{
		try {
			DoctrineHelper::createSchema($this->entityManager, array(
				'Locator_Entity_Places'
			));
		} catch (Exception $e) {
			return LogUtil::registerError($e->getMessage());
		}
		
		try {
			DoctrineHelper::createSchema($this->entityManager, array(
				'Locator_Entity_Layer'
			));
		} catch (Exception $e) {
			return LogUtil::registerError($e->getMessage());
		}
		
		try {
			DoctrineHelper::createSchema($this->entityManager, array(
				'Locator_Entity_ProviderKey'
			));
		} catch (Exception $e) {
			return LogUtil::registerError($e->getMessage());
		}

		$this->addDefaultLayers();

		EventUtil::registerPersistentModuleHandler('Locator', 'module.content.gettypes', array('Locator_Handlers', 'getTypes'));
		// Initialisation successful
		return true;
	}


	/**
	 * Upgrading the module
	 *
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
						'Locator_Entity_OpenstreetmapLayer'
					));
				} catch (Exception $e) {
					echo $e;
					System::shutdown();
					return false;
				}
				self::setStandardLayers();
			case '1.0.0':
				$connection = Doctrine_Manager::getInstance()->getConnection('default');
				$sql = 'DROP TABLE IF EXISTS `Locator_OpenstreetmapLayers`';
				$stmt = $connection->prepare($sql);
				try {
					$stmt->execute();
				} catch (Exception $e) {
					return LogUtil::registerError($e->getMessage());
				}

				try {
					DoctrineHelper::createSchema($this->entityManager, array(
						'Locator_Entity_Layer'
					));
				} catch (Exception $e) {
					return LogUtil::registerError($e->getMessage());
				}
				
				try {
					DoctrineHelper::createSchema($this->entityManager, array(
						'Locator_Entity_ProviderKey'
					));
				} catch (Exception $e) {
					return LogUtil::registerError($e->getMessage());
				}

				$this->addDefaultLayers();

				EventUtil::registerPersistentModuleHandler('Locator', 'module.content.gettypes', array('Locator_Handlers', 'getTypes'));
				break;
			default:
				break;
		}
	return true;
	}

	/**
	 * Uninstall the module
	 *
	 * @return boolean: true on success / false on error
	 */
	public function uninstall()
	{
		//Remove all ModVars
		$this->delVars();
		
		//Remove all databases
		DoctrineHelper::dropSchema($this->entityManager, array(
			'Locator_Entity_Layer'
		));
		DoctrineHelper::dropSchema($this->entityManager, array(
			'Locator_Entity_Places'
		));
		DoctrineHelper::dropSchema($this->entityManager, array(
			'Locator_Entity_ProviderKey'
		));
		
		EventUtil::unregisterPersistentModuleHandler('Locator', 'module.content.gettypes', array('Locator_Handlers', 'getTypes'));
		return true;
	}
}
