<?php
/**
 * Locator Admin controller
 *
 * @license   GPLv3
 * @package   Locator/AdminController
 */
class Locator_Controller_Admin extends Zikula_AbstractController
{
	/**
	 * Post initialise.
	 *
	 * Run after construction.
	 *
	 * @return void
	 */
	protected function postInitialize()
	{
		// Set caching to false by default.
		$this->view->setCaching(Zikula_View::CACHE_DISABLED);
	}
	
	/**
	 * @brief Redirection to view->ot=layer
	 */
	public function main()
	{
		$this->redirect(ModUtil::url($this->name, 'admin', 'view', array('ot' => 'layer')));
	}

	public function view()
	{
		$objectType = $this->request->query->filter('ot', 'providerKey', FILTER_SANITIZE_STRING);
		
		$this->throwForbiddenUnless(SecurityUtil::checkPermission($this->name . ':' . ucwords($objectType) . ':', '::', ACCESS_MODERATE), LogUtil::getErrorMsgPermission());

		$entityClass = $this->name . '_Entity_' . ucwords($objectType);

		// parameter for used sorting field
		$sort = $this->request->query->filter('sort', 'id', FILTER_SANITIZE_STRING);
		
		// parameter for used sort order
		$sdir = $this->request->query->filter('sortdir', '', FILTER_SANITIZE_STRING);
		$sdir = strtolower($sdir);
		if ($sdir != 'asc' && $sdir != 'desc') {
			$sdir = 'asc';
		}

		$em = $this->getService('doctrine.entitymanager');
		$qb = $em->createQueryBuilder();
		$qb->select('p')
		   ->from($entityClass, 'p')
		   ->orderBy('p.' . $sort, $sdir);
		$entities = $qb->getQuery()->getArrayResult();
		$objectCount = count($entities);

		$showAllEntries = $this->request->query->filter('showAllEntries', false, FILTER_SANITIZE_STRING);
		if ($showAllEntries == 1) {
			// retrieve item list without pagination
			//Nothing to do.

		} else {
			// the current offset which is used to calculate the pagination
			$currentPage = (int) $this->request->query->filter('pos', 1, FILTER_VALIDATE_INT);
		
			// the number of items displayed on a page for pagination
			$resultsPerPage = (int) $this->request->query->filter('num', 10, FILTER_VALIDATE_INT);

			// retrieve item list with pagination

			$em = $this->getService('doctrine.entitymanager');
			$qb = $em->createQueryBuilder();
			$qb->select('p')
			   ->from($entityClass, 'p')
			   ->orderBy('p.' . $sort, $sdir)
			   ->setFirstResult(($currentPage - 1) * $resultsPerPage)
			   ->setMaxResults($resultsPerPage);
			$entities = $qb->getQuery()->getArrayResult();
		
			$this->view->assign('currentPage', $currentPage)
					   ->assign('pager', array('numitems'	 => $objectCount,
											   'itemsperpage' => $resultsPerPage));
		}

		// assign the object data, sorting information and details for creating the pager
		$this->view->assign('items', $entities)
				   ->assign('sort', $sort)
				   ->assign('sdir', ($sdir == 'asc') ? 'desc' : 'asc')
				   ->assign('pageSize', $resultsPerPage);
		
		// fetch and return the appropriate template
		return $this->view->fetch('Admin/' . ucfirst($objectType) . '_view.tpl');
	}

	public function edit()
	{
		$objectType = $this->request->query->filter('ot', 'providerKey', FILTER_SANITIZE_STRING);
		$id = $this->request->query->filter('id', null, FILTER_VALIDATE_INT);
		
		$this->throwForbiddenUnless(SecurityUtil::checkPermission($this->name . ':' . ucwords($objectType) . ':', '::', ($id) ? ACCESS_EDIT : ACCESS_ADD), LogUtil::getErrorMsgPermission());
		
		// create new Form reference
		$view = FormUtil::newForm($this->name, $this);
		
		// build form handler class name
		$handlerClass = $this->name . '_Form_Handler_Admin_' . ucfirst($objectType) . '_EditHandler';
		
		// determine the output template
		$template = 'Admin/' . ucfirst($objectType) . '_edit.tpl';

		// execute form using supplied template and page event handler
		return $view->execute($template, new $handlerClass());
	}

	public function delete()
	{
		$objectType = $this->request->query->filter('ot', 'providerKey', FILTER_SANITIZE_STRING);

		$this->throwForbiddenUnless(SecurityUtil::checkPermission($this->name . ':' . ucwords($objectType) . ':', '::', ACCESS_DELETE), LogUtil::getErrorMsgPermission());

		$id = $this->request->query->filter('id', null, FILTER_VALIDATE_INT);
		$this->throwNotFoundUnless(isset($id), $this->__('Error! Invalid identifier received.'));

		$entityClass = $this->name . '_Entity_' . ucwords($objectType);

		$providerKey = $this->entityManager->find($entityClass, $id);
		$this->entityManager->remove($providerKey);
		$this->entityManager->flush();

		$this->registerStatus($this->__('Done! Item deleted.'));
		return $this->redirect(ModUtil::url($this->name, 'admin', 'view', array('ot' => $objectType)));
	}
}
