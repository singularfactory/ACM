<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version98 extends Doctrine_Migration_Base {
	
	protected $strains = array();
	
	protected $strainIsolators = array();
	
	public function preUp() {
		echo ">> preUp() found ";
		
		$strainTable = Doctrine_Core::getTable('Strain');
		$strainTable->setColumn('isolator_id', 'integer', null, array('type' => 'integer'));
		$this->strains = $strainTable->findAll()->toArray();

		echo count($this->strains);
		echo " strains\n";
	}
	
	public function up() {
		echo ">> up(): dropping isolator_id from strain\n";
		$this->dropForeignKey('strain', 'strain_isolator_id_isolator_id');
		$this->removeColumn('strain', 'isolator_id');
		
		echo ">> up(): creating strain_isolators table\n";
		$this->createTable('strain_isolators', array(
			'strain_id' => array('type' => 'integer','primary' => '1','length' => '8',),
			'isolator_id' => array('type' => 'integer','primary' => '1','length' => '8',),
			'created_at' => array('notnull' => '1','type' => 'timestamp','length' => '25',),
			'updated_at' => array('notnull' => '1','type' => 'timestamp','length' => '25',),
		), array(
			'type' => 'INNODB',
			'primary' => array(0 => 'strain_id',1 => 'isolator_id',),
			'collate' => 'utf8_general_ci',
			'charset' => 'utf8',
		));
		$this->createForeignKey('strain_isolators', 'strain_isolators_strain_id_strain_id', array(
			'name' => 'strain_isolators_strain_id_strain_id',
			'local' => 'strain_id',
			'foreign' => 'id',
			'foreignTable' => 'strain',
			'onUpdate' => '',
			'onDelete' => 'cascade',
		));
		$this->createForeignKey('strain_isolators', 'strain_isolators_isolator_id_isolator_id', array(
			'name' => 'strain_isolators_isolator_id_isolator_id',
			'local' => 'isolator_id',
			'foreign' => 'id',
			'foreignTable' => 'isolator',
		));
		$this->addIndex('strain_isolators', 'strain_isolators_strain_id', array('fields' => array(0 => 'strain_id')));
		$this->addIndex('strain_isolators', 'strain_isolators_isolator_id', array('fields' => array(0 => 'isolator_id')));
	}
	
	public function postUp() {
		echo ">> postUp(): initializing strain_isolators table\n";
		foreach ( $this->strains as $strain ) {
			$strainIsolator = new StrainIsolators();
			$strainIsolator->setStrainId($strain['id']);
			$strainIsolator->setIsolatorId($strain['isolator_id']);
			if ( $strainIsolator->trySave() ) {
				echo ">> postUp(): strain {$strain['id']}\n";
				echo ">> postUp(): isolator {$strain['isolator_id']}\n";
			}
		}
	}
	
	public function preDown() {
		$this->strainIsolators = Doctrine_Core::getTable('StrainIsolators')->findAll();
	}

	public function down() {
		$this->dropForeignKey('strain_isolators', 'strain_isolators_strain_id_strain_id');
		$this->dropForeignKey('strain_isolators', 'strain_isolators_isolator_id_isolator_id');
		$this->removeIndex('strain_isolators', 'strain_isolators_strain_id', array('fields' => array(0 => 'strain_id',),));
		$this->removeIndex('strain_isolators', 'strain_isolators_isolator_id', array('fields' => array(0 => 'isolator_id')));
		$this->dropTable('strain_isolators');
		
		$this->addColumn('strain', 'isolator_id', 'integer', '8', array('notnull' => '1'));
		$this->createForeignKey('strain', 'strain_isolator_id_isolator_id', array(
			'name' => 'strain_isolator_id_isolator_id',
			'local' => 'isolator_id',
			'foreign' => 'id',
			'foreignTable' => 'isolator',
		));
	}
	
	public function postDown() {
		foreach ( $this->strainIsolators as $strainIsolator ) {
			$strain = Doctrine_Core::getTable('Strain')->find($strainIsolator->getStrainId());
			$strain->setIsolatorId($strainIsolator->getIsolatorId());
			$strain->trySave();
		}
	}
	
}