<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version215 extends Doctrine_Migration_Base {
	public function up() {
		$this->removeColumn('strain', 'in_g_catalog');
	}

	public function down() {
		$this->addColumn('strain', 'in_g_catalog', 'boolean', '25', array( 'notnull' => '1', 'default' => '0',));
	}
}