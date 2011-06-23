<?php

class AddNotebookCodeColumn extends Doctrine_Migration_Base {
	public function up() {
		$this->addColumn('sample', 'notebook_code', 'integer', 8, array('notnull' => true));
	}

	public function down() {
		$this->removeColumn('sample', 'notebook_code');
	}
}
