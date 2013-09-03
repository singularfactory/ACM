<?php
class Version217 extends Doctrine_Migration_Base {
	public function up() {
		$this->changeColumn('sample', 'notebook_code', 'string', '255', array());
	}

	public function down() {
		$this->changeColumn('sample', 'notebook_code', 'string', '40', array());
	}
}