<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version106 extends Doctrine_Migration_Base {
	public function up() {
		$this->createForeignKey('patent_deposit_culture_media', 'patent_deposit_culture_media_culture_medium_id_culture_medium_id', array(
			'name' => 'patent_deposit_culture_media_culture_medium_id_culture_medium_id',
			'local' => 'culture_medium_id',
			'foreign' => 'id',
			'foreignTable' => 'culture_medium',
		));
		$this->addIndex('patent_deposit_culture_media', 'patent_deposit_culture_media_culture_medium_id', array('fields' => array(0 => 'culture_medium_id')));
	}

	public function down() {
		$this->dropForeignKey('patent_deposit_culture_media', 'patent_deposit_culture_media_culture_medium_id_culture_medium_id');
		$this->removeIndex('patent_deposit_culture_media', 'patent_deposit_culture_media_culture_medium_id', array('fields' => array(0 => 'culture_medium_id')));
	}
}