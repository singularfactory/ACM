<?php

class UpdateCollectorRelationship extends Doctrine_Migration_Base
{
	public function up()
	{
		// Drop the foreign key that references sfGuardUser in Sample table
		$this->dropForeignKey('sample', 'sample_collector_id_sf_guard_user_id');

		// Create a foreign key that references Collector in Sample table
		$this->createForeignKey('sample', 'sample_collector_id_collector_id', array(
			'name' => 'sample_collector_id_collector_id',
			'local' => 'collector_id',
			'foreign' => 'id',
			'foreignTable' => 'collector',
		));
	}

	public function down()
	{
		// Drop the foreign key that references Collector in Sample table
		$this->dropForeignKey('sample', 'sample_collector_id_collector_id');

		// Create a foreign key that references sfGuardUser in Sample table
		$this->createForeignKey('sample', 'sample_collector_id_sf_guard_user_id', array(
			'name' => 'sample_collector_id_sf_guard_user_id',
			'local' => 'collector_id',
			'foreign' => 'id',
			'foreignTable' => 'sf_guard_user',
		));
	}
}
