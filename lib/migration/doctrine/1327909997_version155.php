<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version155 extends Doctrine_Migration_Base {
	public function up() {
		$this->changeColumn('pcr_gel', 'band', 'integer', '8', array());
	}

	public function down() {
		$this->changeColumn('pcr_gel', 'band', 'decimal', '18', array());
	}
}