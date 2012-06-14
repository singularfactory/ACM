<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version187 extends Doctrine_Migration_Base {
	public function up() {
		$this->createForeignKey('patent_deposit', 'patent_deposit_supervisor_id_sf_guard_user_id', array(
			'name' => 'patent_deposit_supervisor_id_sf_guard_user_id',
			'local' => 'supervisor_id',
			'foreign' => 'id',
			'foreignTable' => 'sf_guard_user',
		));
/*        $this->addIndex('patent_deposit', 'patent_deposit_supervisor_id', array(
						 'fields' => 
						 array(
							0 => 'supervisor_id',
						 ),
));*/
	}

	public function down() {
		$this->dropForeignKey('patent_deposit', 'patent_deposit_supervisor_id_sf_guard_user_id');
/*        $this->removeIndex('patent_deposit', 'patent_deposit_supervisor_id', array(
						 'fields' => 
						 array(
							0 => 'supervisor_id',
						 ),
));*/
	}
}
