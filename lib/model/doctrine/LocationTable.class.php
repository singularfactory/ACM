<?php

/**
 * LocationTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class LocationTable extends Doctrine_Table {
    /**
     * Returns an instance of this class.
     *
     * @return object LocationTable
     */
    public static function getInstance() {
        return Doctrine_Core::getTable('Location');
    }

	/**
	 * Returns a query that select locations ordered by name
	 * 
	 * @return object DoctrineRecord
	 * @author Eliezer Talon
	 * @version 2011-04-14
	 */
	public function getSortedByNameQuery() {
		return $this->createQuery('l')->orderBy('l.name ASC');
	}
	
	public function getDefaultLocationId() {
		$location = $this->createQuery('l')->fetchOne();
		return $location->getId();
	}
	
	public function findByTerm($term = '') {
		return $this->createQuery('l')->where('l.name LIKE ?', "%$term%")->execute();
	}
}