<?php
/**
 * Locator Admin-Form LayersOnOff
 *
 * @license    GPLv3
 * @package    Locator/AdminController/Form/Handler/LayersOnOff
 */

/**
 * @brief Register FormHandler
 */
class Locator_Form_Handler_Admin_AddLayer extends Zikula_Form_AbstractHandler
{
	/**
	 * @brief Setup form.
	 *
	 * @param Zikula_Form_View $view Current Zikula_Form_View instance.
	 * @return boolean
	 *
	 * @author Leonard Marschke
	 * @version 1.0
	 */
	function initialize(Zikula_Form_View $view)
	{
		$lid = FormUtil::getPassedValue('lid', null, 'GET');
		if($lid != null)
			$layer = $this->entityManager->find('Locator_Entity_Layers', $lid);
		else
			$layer = array('active' => true);
		$this->view->assign('layer', $layer);
	}

	/**
	 * @brief Handle form submission.
	 * @param Zikula_Form_View $view  Current Zikula_Form_View instance.
	 * @param array &$args Arguments.
	 * @return bool|void
	 *
	 *
	 * @author Leonard Marschke
	 * @version 1.0
	 */
	function handleCommand(Zikula_Form_View $view, &$args)
	{
		if ($args['commandName'] == 'cancel') {
			LogUtil::RegisterStatus($view->__('Adding of layer canceled'));
			return $view->redirect(ModUtil::url('Locator', 'admin', 'main'));
		}


		// check for valid form
		if (!$view->isValid())
			return false;

		$data = $view->getValues();

		$lid = FormUtil::getPassedValue('lid', null, 'GET');

		if($lid != null)
		{
			$layer = $this->entityManager->find('Locator_Entity_Layers', $lid);
		}
		else
		{
			$layer = new Locator_Entity_OpenstreetmapLayers();
		}
		$layer->setName($data['name']);
		$layer->setCode($data['code']);
		$layer->setActive($data['active']);
		
		$this->entityManager->persist($layer);
		$this->entityManager->flush();

		LogUtil::registerStatus($this->__('Layer added successfully!'));

		return System::redirect(ModUtil::url('Locator', 'admin', 'main'));
	}
}
