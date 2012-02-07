<?php

/**
* MyActions actions class.
*
* @package    bna_green_house
* @subpackage backend
* @author     Eliezer Talon <elitalon@inventiaplus.com>
* @version		2011-06-30
*/
class MyActions extends sfActions {
	
	/**
	 * Deletes a object if it is not referenced by any foreign key
	 *
	 * @param sfWebRequest $request 
	 * @return void
	 * @author Eliezer Talon
	 */
	public function executeDeleteIfNotUsed(sfWebRequest $request) {
	  $request->checkCSRFProtection();

	  $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
		
		$module = $this->request->getParameter('module');
		$moduleReadableNameLowercase = str_replace('_', ' ', $module);
		try {
			if ( $this->getRoute()->getObject()->delete() ) {
		    $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
		  }
		}
		catch (Exception $e) {
			$this->getUser()->setFlash('error', "This $moduleReadableNameLowercase cannot be deleted because it is being used in other records");
		}
		
	  $this->redirect('@'.sfInflector::tableize($module));
	}
	
	protected function executeBatchDeleteIfNotUsed(sfWebRequest $request) {
		$ids = $request->getParameter('ids');
		$module = $this->request->getParameter('module');
		
		$records = Doctrine_Query::create()
			->from(sfInflector::camelize($module))
			->whereIn('id', $ids)
			->execute();
		
		$error = false;
		foreach ( $records as $record ) {
			try {
				$record->delete();
			}
			catch (Exception $e) {
				$error = true;
			}
		}
		
		if ( $error ) {
			$this->getUser()->setFlash('error', 'One or more items could not be deleted because they are being used in other records.');
		}
		else {
			$this->getUser()->setFlash('notice', 'The selected items have been deleted successfully.');
		}
		
		$this->redirect('@'.sfInflector::tableize($module));
	}
	
}



