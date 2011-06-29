<?php

class AddIsExtremophileColumn extends Doctrine_Migration_Base {
  public function up() {
		$this->addColumn('sample', 'is_extremophile', 'boolean', null, array('notnull' => true, 'default' => 0));
  }

  public function down() {
		$this->removeColumn('sample', 'is_extremophile');
  }
}
