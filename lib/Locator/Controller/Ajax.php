<?php
/**
 * Locator Ajax controller
 *
 * @license   GPLv3
 * @package   Locator/AjaxController
 */
class Locator_Controller_Ajax extends Zikula_AbstractController
{
	public function toggleValue()
	{
		$id = $this->request->query->filter('id', null, FILTER_VALIDATE_INT);
		$field = $this->request->query->filter('field', null, FILTER_SANITIZE_STRING);

		$layer = $this->entityManager->find('Locator_Entity_Layer', $id);
		
		$methodSet = 'set' . ucfirst($field);
		$methodGet = 'get' . ucfirst($field);
		
		$old = $layer->$methodGet();

		$layer->$methodSet(!$old);
		
		$this->entityManager->persist($layer);
		$this->entityManager->flush();
		
		// url_check
		require_once $this->view->_get_plugin_filepath('function','img');
		
		$img = smarty_function_img(array('modname' => 'core', 'set' => 'icons/extrasmall', 'src' => (!$old) ? 'button_ok.png' : 'button_cancel.png'), $this->view);
		echo $img;

		return true;
	}
}
