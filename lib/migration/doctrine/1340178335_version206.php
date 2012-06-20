<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version206 extends Doctrine_Migration_Base {
	public function up() {
		$this->changeColumn('external_strain', 'subkingdom_id', 'integer', '8', array('notnull' => 0));
		$this->changeColumn('external_strain', 'phylum_id', 'integer', '8', array('notnull' => 0));
		$this->changeColumn('external_strain', 'taxonomic_order_id', 'integer', '8', array('notnull' => 0));
		$this->changeColumn('external_strain', 'family_id', 'integer', '8', array('notnull' => 0));
	}

	public function down() {
		$this->changeColumn('external_strain', 'subkingdom_id', 'integer', '8', array('notnull' => 1));
		$this->changeColumn('external_strain', 'phylum_id', 'integer', '8', array('notnull' => 1));
		$this->changeColumn('external_strain', 'taxonomic_order_id', 'integer', '8', array('notnull' => 1));
		$this->changeColumn('external_strain', 'family_id', 'integer', '8', array('notnull' => 1));
	}
}
