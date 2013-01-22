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
class Locator_Form_Handler_Admin_LayersOnOff extends Zikula_Form_AbstractHandler
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
		$layer = $this->entityManager->getRepository('Locator_Entity_OpenstreetmapLayers')->findBy(array());
		$this->view->assign('layerOSM', $layer);
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

		foreach($data as $key => $row)
		{
			$layer = $this->entityManager->find('Locator_Entity_OpenstreetmapLayers', $key);
			$layer->setActive($row);
			$this->entityManager->persist($layer);
		}

		$this->entityManager->flush();

		LogUtil::registerStatus($this->__('Layer edited successfully!'));

		return System::redirect(ModUtil::url('Locator', 'admin', 'main'));
	}
}
