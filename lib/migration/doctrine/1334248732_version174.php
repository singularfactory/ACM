<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version174 extends Doctrine_Migration_Base {
	public function up() {
		$this->addColumn('strain', 'phylogenetic_description', 'string', '', array());
		$this->addColumn('strain', 'phylogenetic_tree', 'string', '255', array('notnull' => '0',));
	}

	public function down() {
		$this->removeColumn('strain', 'phylogenetic_description');
		$this->removeColumn('strain', 'phylogenetic_tree');
	}
}