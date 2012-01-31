<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version156 extends Doctrine_Migration_Base {
	public function up() {
		$this->changeColumn('location', 'latitude', 'string', '12', array('fixed' => '1',));
		$this->changeColumn('location', 'longitude', 'string', '12', array('fixed' => '1',));
		$this->changeColumn('sample', 'latitude', 'string', '12', array('fixed' => '1',));
		$this->changeColumn('sample', 'longitude', 'string', '12', array('fixed' => '1',));
	}

	public function down() {
		$this->changeColumn('location', 'latitude', 'string', '10', array('fixed' => '1',));
		$this->changeColumn('location', 'longitude', 'string', '10', array('fixed' => '1',));
		$this->changeColumn('sample', 'latitude', 'string', '10', array('fixed' => '1',));
		$this->changeColumn('sample', 'longitude', 'string', '10', array('fixed' => '1',));
	}
}