<?php

class Addmodulecolumn extends Doctrine_Migration_Base
{
	public function up()
	{
		$this->addColumn('event', 'module', 'string', 40, array('notnull' => true));
	}

	public function down()
	{
		$this->removeColumn('event', 'module');
	}
}
