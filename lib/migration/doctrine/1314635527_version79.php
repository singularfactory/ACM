<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version79 extends Doctrine_Migration_Base {
	public function up() {
		$this->addColumn('purchase_item', 'product_id', 'integer', '8', array('notnull' => '1'));
	}

	public function down() {
		$this->removeColumn('purchase_item', 'product_id');
	}
}