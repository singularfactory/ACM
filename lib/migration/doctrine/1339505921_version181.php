<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version181 extends Doctrine_Migration_Base {
	public function up() {
		$this->changeColumn('external_strain', 'species_id', 'integer', '8', array('notnull' => 0));
	}

	public function down() {
		$this->changeColumn('external_strain', 'species_id', 'integer', '8', array('notnull' => 1));
	}
}
