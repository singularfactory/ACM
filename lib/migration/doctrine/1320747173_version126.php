<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version126 extends Doctrine_Migration_Base {
	public function up() {
		$this->addColumn('project', 'name', 'string', '200', array('notnull' => '1',));
	}
	
	public function down() {
		$this->removeColumn('project', 'name');
	}
}