<?php
/**
 * acm : Algae Culture Management (https://github.com/singularfactory/ACM)
 * Copyright 2012, Singular Factory <info@singularfactory.com>
 *
 * This file is part of ACM
 *
 * ACM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ACM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ACM.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright     Copyright 2012, Singular Factory <info@singularfactory.com>
 * @package       ACM.Backend
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */
?>
<?php

/**
 * MyActions actions class.
 *
 * @package ACM.Backend
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
