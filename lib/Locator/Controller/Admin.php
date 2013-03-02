<?php
/**
 * Locator Admin controller
 *
 * @license    GPLv3
 * @package    Locator/AdminController
 */
class Locator_Controller_Admin extends Zikula_AbstractController
{
	/**
	 * @brief Redirection to layersOnOff
	 *
	 * @author Leonard Marschke
	 * @version 1.0
	 */
	public function main()
	{
		$this->redirect(ModUtil::url($this->name, 'admin', 'layersOnOff'));
	}
	
	
	/**
	 * @brief Allows user to switch layers on or off
	 *
	 * @return string html string
	 *
	 * @author Leonard Marschke
	 * @version 1.0
	 */
	public function layersOnOff()
	{
		if(!SecurityUtil::checkPermission('Locator::', '::', ACCESS_ADMIN))
			return LogUtil::registerPermissionError();
		
		$form = FormUtil::newForm($this->name, $this);
		return $form->execute('Admin/LayersOnOff.tpl', new Locator_Form_Handler_Admin_LayersOnOff());
	}
	
	
	/**
	 * @brief Allows user to add and edit OpenStreetMap layers
	 *
	 * @return string html string
	 *
	 * @author Leonard Marschke
	 * @version 1.0
	 */
	public function addOpenStreetMapLayer()
	{
		if(!SecurityUtil::checkPermission('Locator::', '::', ACCESS_ADMIN))
			return LogUtil::registerPermissionError();
		
		$form = FormUtil::newForm($this->name, $this);
		return $form->execute('Admin/AddOpenStreetMapLayer.tpl', new Locator_Form_Handler_Admin_AddOpenStreetMapLayer());
	}
	
	/**
	 * @brief Allows user to remove OpenStreetMap layers
	 *
	 * @return redirect
	 *
	 * @author Leonard Marschke
	 * @version 1.0
	 */
	public function removeOpenStreetMapLayer()
	{
		if(!SecurityUtil::checkPermission('Locator::', '::', ACCESS_ADMIN))
			return LogUtil::registerPermissionError();
		
		$lid = FormUtil::getPassedValue('lid', null, 'GET');
		
		if($lid == null)
			return LogUtil::registerError($this->__('No lid given'));
		
		$layer = $this->entityManager->find('Locator_Entity_Layers', $lid);
		if($layer['id'] == '')
			return LogUtil::registerError($this->__('No valid lid given'));
		$this->entityManager->remove($layer);
		$this->entityManager->flush();
		
		LogUtil::registerStatus($this->__('Entry successfuly removed'));
		
		$this->redirect(ModUtil::url($this->name, 'admin', 'main'));
		return true;
	}
}
