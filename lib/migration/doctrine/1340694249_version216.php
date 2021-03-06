<?php
class Version216 extends Doctrine_Migration_Base {
	public function up() {
		$this->changeColumn('patent_deposit', 'taxonomic_class_id', 'integer', '8', array());
		$this->changeColumn('patent_deposit', 'genus_id', 'integer', '8', array());
	}

	public function down() {
		$this->changeColumn('patent_deposit', 'taxonomic_class_id', 'integer', '8', array('notnull' => '1'));
		$this->changeColumn('patent_deposit', 'genus_id', 'integer', '8', array('notnull' => '1'));
	}
}
