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
			if ( preg_match('/^\w+\.\w+$/', $sort_column) ) {
				list($relatedTable, $relatedColumn) = explode('.', $sort_column);
				$pager->setQuery($query->leftJoin("{$this->mainAlias}.$relatedTable {$this->relatedAlias}")->orderBy("{$this->relatedAlias}.$relatedColumn ".$this->sortDirection));
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
				$thumbnail = $commonPath.sfConfig::get('app_thumbnails_dir').'/'.$filename;
				
				unlink($image);
				unlink($thumbnail);
			}
		}
	}
}
