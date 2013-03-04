<?php

class Locator_Form_Handler_Admin_Layer_EditHandler extends Zikula_Form_AbstractHandler
{
	private $edit = false;
	
	private $layer;

	/**
	 * Initialize form handler.
	 *
	 * This method takes care of all necessary initialisation of our data and form states.
	 *
	 * @param Zikula_Form_View $view The form view instance.
	 *
	 * @return boolean False in case of initialization errors, otherwise true.
	 */
	public function initialize(Zikula_Form_View $view)
	{
		$id = $this->request->query->filter('id', null, FILTER_VALIDATE_INT);

		if(is_numeric($id))
		{
			$this->edit = true;

			$this->layer = $this->entityManager->find('Locator_Entity_Layer', $id);
			
			$layer = $this->layer->toArray();
			$layer['selectable'] = !$layer['selectable'];

			$view->assign('edit', true)
				 ->assign('layer', $layer);
		}
		else
		{
			$this->layer = new Locator_Entity_Layer();
			$view->assign('edit', false);
		}

		$provider = Locator_Util::getProviderForFormDropdown();
		$view->assign('provider', $provider);

		return true;
	}

	/**
	 * Command event handler.
	 *
	 * This event handler is called when a command is issued by the user.
	 *
	 * @param Zikula_Form_View $view The form view instance.
	 * @param array			$args Additional arguments.
	 *
	 * @return mixed Redirect or false on errors.
	 */
	public function handleCommand(Zikula_Form_View $view, &$args)
	{
		$url = ModUtil::url('Locator', 'admin', 'view', array('ot' => 'layer'));
		
		if ($args['commandName'] == 'cancel') {
			LogUtil::RegisterStatus($view->__('Adding of layer canceled'));
			return $view->redirect($url);
		}


		// check for valid form
		if (!$view->isValid())
			return false;

		$data = $view->getValues();

		if(!$this->edit)
		{
			$this->layer->setName($data['name']);
			$this->layer->setMapTypes($data['mapTypes']);
			$this->layer->setUrl($data['url']);
			$this->layer->setLicense($data['license']);
			$this->layer->setMinZoom($data['minZoom']);
			$this->layer->setMaxZoom($data['maxZoom']);
			$this->layer->setOpacity($data['opacity']);
			$this->layer->setAlwaysOn($data['alwaysOn']);
			$this->layer->setActive($data['active']);
		}
		else
		{
			$this->layer->merge($data);
		}
		$this->entityManager->persist($this->layer);
		$this->entityManager->flush();
	
		return LogUtil::registerStatus($this->__('Done! Item created.'), $url);
	}
}
