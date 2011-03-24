<?php

class AddNotNullAttributetoSampleColumns extends Doctrine_Migration_Base {
  public function up() {
	$this->changeColumn('sample', 'radiation_id', 'integer', 8, array('notnull' => true));
  }

  public function down() {
	$this->changeColumn('sample', 'radiation_id', 'integer', 8, array('notnull' => false));
  }
}
