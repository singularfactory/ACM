<?php

/**
 * SampleTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class SampleTable extends Doctrine_Table {
	/**
	 * Returns an instance of this class.
	 *
	 * @return object SampleTable
	 */
	public static function getInstance() {
	    return Doctrine_Core::getTable('Sample');
	}
	
	public function getSortedByNameQuery() {
		return $this->createQuery('s')->orderBy('s.id ASC');
	}
	
	public function findByTerm($term = '') {
		// Parse ID
		$id = '';
		if ( preg_match('/0+(\d)/', $term, $matches) ) {
			$id = $matches[1];
		}

		return $this->createQuery('s')
			->leftJoin('s.Location l')
			->leftJoin('l.Country c')
			->leftJoin('l.Region r')
			->leftJoin('l.Island i')
			->where('s.id LIKE ?', $id)
			->orWhere('s.notebook_code LIKE ?', "%$term%")
			->orWhere('c.code LIKE ?', "%$term%")
			->orWhere('r.code LIKE ?', "%$term%")
			->orWhere('i.code LIKE ?', "%$term%")
			->execute();
	}
	
	public function getDefaultSampleId() {
		$sample = $this->createQuery('s')->fetchOne();
		if ( $sample ) {
			return (int)$sample->getId();
		}
		
		return 0;
	}
	
}