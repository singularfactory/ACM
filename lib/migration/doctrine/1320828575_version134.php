<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version134 extends Doctrine_Migration_Base {
	public function up() {
		$this->addColumn('strain_isolators', 'sort_order', 'integer', '8', array('notnull' => '1',));
	}

	public function down() {
		$this->removeColumn('strain_isolators', 'sort_order');
	}
}