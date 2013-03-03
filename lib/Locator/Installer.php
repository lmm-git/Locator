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
	 * Initialise the Locator module.
	 *
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
			return LogUtil::registerError($e->getMessage());
		}
		
		try {
			DoctrineHelper::createSchema($this->entityManager, array(
				'Locator_Entity_Layers'
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
						'Locator_Entity_OpenstreetmapLayers'
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
						'Locator_Entity_Layers'
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
			'Locator_Entity_Layers'
		));
		DoctrineHelper::dropSchema($this->entityManager, array(
			'Locator_Entity_Places'
		));
		DoctrineHelper::dropSchema($this->entityManager, array(
			'Locator_Entity_ProviderKey'
		));
		
		return true;
	}
}
