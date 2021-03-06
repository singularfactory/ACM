<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version183 extends Doctrine_Migration_Base {
	public function up() {
		$this->createForeignKey('strain', 'strain_culture_medium_id_culture_medium_id', array(
			'name' => 'strain_culture_medium_id_culture_medium_id',
			'local' => 'culture_medium_id',
			'foreign' => 'id',
			'foreignTable' => 'culture_medium',
		));
	}

	public function down() {
		$this->dropForeignKey('strain', 'strain_culture_medium_id_culture_medium_id');
	}
}
