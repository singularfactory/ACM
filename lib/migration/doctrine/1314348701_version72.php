<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version72 extends Doctrine_Migration_Base {
	public function up() {
		$this->addColumn('strain', 'amount', 'integer', '8', array('notnull' => '1','default' => '0'));
	}

	public function down() {
		$this->removeColumn('strain', 'amount');
	}
}