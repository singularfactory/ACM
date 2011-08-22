<?php

/**
* MyActions actions class.
*
* @package    bna_green_house
* @subpackage frontend
* @author     Eliezer Talon <elitalon@inventiaplus.com>
*/
class MyActions extends sfActions {

	/**
	 * paginationOptions
	 *
	 * @var array
	 */
	protected $paginationOptions = array(
		'sort_direction' => 'asc',
		'sort_column' => 'name',
		'init' => true,
	);
	
	/**
	 * mainAlias
	 *
	 * @var string
	 */
	protected $mainAlias = 'sf_main_alias';
	
	/**
	 * relatedAlias
	 *
	 * @var string
	 */
	protected $relatedAlias = 'sf_related_alias';
	
	
	/**
	 * buildPagination
	 *
	 * @param sfWebRequest $request Request made from page
	 * @param string $table Name of the table to paginate
	 * @param array $options Options to configure the pagination
	 * @return sfDoctrinePager
	 * @author Eliezer Talon
	 */
	protected function buildPagination(sfWebRequest $request, $table, array $options = array()) {
		// Merge default options with requested options
		foreach ($options as $key => $value) {
			if ( $value !== null && !empty($value) ) {
				$this->paginationOptions[$key] = $value;
			}
		}
		
		// Initiate a pager
		$pager = new sfDoctrinePager($table, sfConfig::get('app_max_list_items'));
		
		// Set sort direction
		if ( $request->getParameter('sort_direction') ) {
			$this->sortDirection = $request->getParameter('sort_direction');
		}
		else {
			$this->sortDirection = $this->paginationOptions['sort_direction'];
		}

		// Set sort columns
		$query = Doctrine::getTable($table)->createQuery($this->mainAlias);
		if ( $sort_column = $request->getParameter('sort_column') ) {
			if ( preg_match('/^(\w+\.(\w+\.)*)(\w+)$/', $sort_column, $matches) ) {
				$relations = preg_replace('/\.$/', '', $matches[1]);
				$relatedColumn = $matches[3];
				$pager->setQuery($query->leftJoin("{$this->mainAlias}.$relations {$this->relatedAlias}")->orderBy("{$this->relatedAlias}.$relatedColumn ".$this->sortDirection));
			}
			else {
				$pager->setQuery($query->orderBy("{$this->mainAlias}.$sort_column ".$this->sortDirection));
			}
		}
		else {
			$pager->setQuery($query->orderBy("{$this->mainAlias}.{$this->paginationOptions['sort_column']} ".$this->sortDirection));
		}
		
		$pager->setPage($request->getParameter('page', 1));
		
		if ( $this->paginationOptions['init'] ) {
			$pager->init();
		}
		
		return $pager;
	}
	
	/**
	 * mainAlias
	 *
	 * @return string
	 * @author Eliezer Talon
	 */
	protected function mainAlias() {
		return $this->mainAlias;
	}
	
	/**
	 * relatedAlias
	 *
	 * @return string
	 * @author Eliezer Talon
	 */
	protected function relatedAlias() {
		return $this->relatedAlias;
	}
	
	/**
	 * getRemovablePictures
	 *
	 * @param array $form A form sent by the user
	 * @param string $widgetName Alternate name of the widget that stores the picture information
	 * @return array List of picture filenames
	 * @author Eliezer Talon
	 */
	protected function getRemovablePictures(sfFormObject $form, $widgetName = 'Pictures') {
		$filenames = array();
		if ( isset($form[$widgetName]) ) {
			foreach ( $form[$widgetName] as $index => $pictures ) {
				foreach ($pictures as $key => $field) {
					if ( $key === 'delete_object' && $field->getValue() === 'on' ) {
						$filenames[] = $pictures['filename']->getValue();
					}
				}
			}
		}
		
		return $filenames;
	}
	
	/**
	 * removePicturesFromFilesystem
	 *
	 * @param array $filenames List of filenames to be removed
	 * @return void
	 * @author Eliezer Talon
	 */
	protected function removePicturesFromFilesystem(array $filenames, $subdirectory) {
		if ( !empty($filenames) ) {
			foreach( $filenames as $filename ) {
				$commonPath = sfConfig::get('sf_web_dir').sfConfig::get('app_pictures_dir').$subdirectory;
				$image = $commonPath.'/'.$filename;
				$thumbnail = preg_replace('/\.[\-\w]+$/', sfConfig::get('app_thumbnail_extension'), $commonPath.sfConfig::get('app_thumbnails_dir').'/'.$filename);
				
				unlink($image);
				unlink($thumbnail);
			}
		}
	}

	/**
	 * Deletes a object if it is not referenced by any foreign key
	 *
	 * @param sfWebRequest $request 
	 * @return void
	 * @author Eliezer Talon
	 */
	public function executeDelete(sfWebRequest $request) {
		$request->checkCSRFProtection();
		
		$id = $request->getParameter('id');
		$module = $this->request->getParameter('module');
		$moduleReadableName = sfInflector::humanize($module);
		$moduleReadableNameLowercase = str_replace('_', ' ', $module);
		
		$this->forward404Unless($model = Doctrine_Core::getTable(sfInflector::camelize($module))->find(array($id)), sprintf('Object does not exist (%s).', $id));
		
		try {
			// Remove pictures if any
			$removablePictures = array();
			if ( $module === 'location' || $module === 'sample' || $module === 'strain' ) {
				foreach ($model->getPictures() as $picture ) {
					$removablePictures[] = $picture->getFilename();
				}
			}
			
			$model->delete();
			$this->removePicturesFromFilesystem($removablePictures, sfConfig::get("app_{$module}_pictures_dir"));
			
			$this->dispatcher->notify(new sfEvent($this, 'bna_green_house.event_log'));
			$this->getUser()->setFlash('notice', "$moduleReadableName deleted successfully");
		}
		catch (Exception $e) {
			$this->getUser()->setFlash('notice', "This $moduleReadableNameLowercase cannot be deleted because it is being used in other records");
		}
		
		$this->redirect("@$module?page=".$this->getUser()->getAttribute("$module.index_page"));
	}
	
	
	public function executeUploadProgress(sfWebRequest $request) {
		$apc_status = apc_fetch( 'upload_'.$request->getParameter('id'));
		$percentage = 1;
		if ( $apc_status['current'] != 0 ) {
			$percentage = $apc_status['current'] / $apc_status['total']*100;
		}
		
		$this->setLayout(false);
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		$this->getResponse()->setContent($percentage);
		return sfView::NONE;
	}
		
}
