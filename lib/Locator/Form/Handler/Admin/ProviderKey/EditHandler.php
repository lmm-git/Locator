<?php

class Locator_Form_Handler_Admin_ProviderKey_EditHandler extends Zikula_Form_AbstractHandler
{
	private $edit = false;
	
	private $providerKey;

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

			$this->providerKey = $this->entityManager->find('Locator_Entity_ProviderKey', $id);
			
			$view->assign('edit', true)
				 ->assign('key', $this->providerKey->toArray());
		}
		else
		{
			$this->providerKey = new Locator_Entity_ProviderKey();
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
		$url = ModUtil::url('Locator', 'admin', 'view', array('ot' => 'providerKey'));
		
		if ($args['commandName'] == 'cancel') {
			LogUtil::RegisterStatus($view->__('Adding of provider key canceled'));
			return $view->redirect($url);
		}


		// check for valid form
		if (!$view->isValid())
			return false;

		$data = $view->getValues();
		
		if(!$this->edit)
		{
			$this->providerKey->setMapType($data['mapType']);
			$this->providerKey->setProviderKey($data['providerKey']);
			$this->providerKey->setProviderKey2($data['providerKey2']);
		}
		else
		{
			$this->providerKey->merge($data);
		}
		$this->entityManager->persist($this->providerKey);
		$this->entityManager->flush();
	
		return LogUtil::registerStatus($this->__('Done! Item created.'), $url);
	}
}
