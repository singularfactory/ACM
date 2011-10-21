<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version122 extends Doctrine_Migration_Base {
	
	protected $strains = array();
	protected $maintenanceDeposits = array();
	protected $patentDeposits = array();
	
	protected $strainMaintenanceStatus = array();
	protected $maintenanceDepositMaintenanceStatus = array();
	protected $patentDepositMaintenanceStatus = array();
	
	public function preUp() {
		echo ">> preUp() found ";
		
		$strainTable = Doctrine_Core::getTable('Strain');
		$strainTable->setColumn('maintenance_status_id', 'integer', null, array('type' => 'integer'));
		$this->strains = $strainTable->findAll()->toArray();
		
		$maintenanceDepositTable = Doctrine_Core::getTable('MaintenanceDeposit');
		$maintenanceDepositTable->setColumn('maintenance_status_id', 'integer', null, array('type' => 'integer'));
		$this->maintenanceDeposits = $maintenanceDepositTable->findAll()->toArray();
		
		$patentDepositTable = Doctrine_Core::getTable('PatentDeposit');
		$patentDepositTable->setColumn('maintenance_status_id', 'integer', null, array('type' => 'integer'));
		$this->patentDeposits = $patentDepositTable->findAll()->toArray();

		echo sprintf("%d strains, %d maintenance deposits and %d patent deposits\n", count($this->strains), count($this->maintenanceDeposits), count($this->patentDeposits));
	}
	
	public function up() {
		echo ">> up(): dropping maintenance_status_id from strain, maintenance deposit and patent deposit\n";
		$this->dropForeignKey('maintenance_deposit', 'maintenance_deposit_maintenance_status_id_maintenance_status_id');
		$this->dropForeignKey('patent_deposit', 'patent_deposit_maintenance_status_id_maintenance_status_id');
		$this->dropForeignKey('strain', 'strain_maintenance_status_id_maintenance_status_id');
		$this->removeColumn('patent_deposit', 'maintenance_status_id');
		$this->removeColumn('maintenance_deposit', 'maintenance_status_id');
		$this->removeColumn('strain', 'maintenance_status_id');
		
		echo ">> up(): creating strain_maintenance_status table\n";
		$this->createTable('strain_maintenance_status', array(
			'strain_id' => array('type' => 'integer','primary' => '1','length' => '8'),
			'maintenance_status_id' => array('type' => 'integer','primary' => '1','length' => '8'),
			'created_at' => array('notnull' => '1','type' => 'timestamp','length' => '25'),
			'updated_at' => array('notnull' => '1','type' => 'timestamp','length' => '25'),
		), array(
			'type' => 'INNODB',
			'primary' => array(0 => 'strain_id',1 => 'maintenance_status_id'),
			'collate' => 'utf8_general_ci',
			'charset' => 'utf8',
		));
		$this->createForeignKey('strain_maintenance_status', 'strain_maintenance_status_strain_id_strain_id', array(
			'name' => 'strain_maintenance_status_strain_id_strain_id',
			'local' => 'strain_id',
			'foreign' => 'id',
			'foreignTable' => 'strain',
			'onUpdate' => '',
			'onDelete' => 'cascade',
		));
		$this->createForeignKey('strain_maintenance_status', 'smmi', array(
			'name' => 'smmi',
			'local' => 'maintenance_status_id',
			'foreign' => 'id',
			'foreignTable' => 'maintenance_status',
		));
		$this->addIndex('strain_maintenance_status', 'strain_maintenance_status_strain_id', array('fields' => array(0 => 'strain_id',),));
		$this->addIndex('strain_maintenance_status', 'strain_maintenance_status_maintenance_status_id', array('fields' => array(0 => 'maintenance_status_id',),));
		
		echo ">> up(): creating maintenance_deposit_maintenance_status table\n";
		$this->createTable('maintenance_deposit_maintenance_status', array(
			'maintenance_deposit_id' => array('type' => 'integer','primary' => '1','length' => '8'),
			'maintenance_status_id' => array('type' => 'integer','primary' => '1','length' => '8'),
			'created_at' => array('notnull' => '1','type' => 'timestamp','length' => '25'),
			'updated_at' => array('notnull' => '1','type' => 'timestamp','length' => '25'),
		), array(
			'type' => 'INNODB',
			'primary' => array(0 => 'maintenance_deposit_id',1 => 'maintenance_status_id'),
			'collate' => 'utf8_general_ci',
			'charset' => 'utf8',
		));
		$this->createForeignKey('maintenance_deposit_maintenance_status', 'mmmi_7', array(
			'name' => 'mmmi_7',
			'local' => 'maintenance_deposit_id',
			'foreign' => 'id',
			'foreignTable' => 'maintenance_deposit',
			'onUpdate' => '',
			'onDelete' => 'cascade',
		));
		$this->createForeignKey('maintenance_deposit_maintenance_status', 'mmmi_8', array(
			'name' => 'mmmi_8',
			'local' => 'maintenance_status_id',
			'foreign' => 'id',
			'foreignTable' => 'maintenance_status',
			'onUpdate' => '',
		));
		$this->addIndex('maintenance_deposit_maintenance_status', 'md_ms1', array('fields' => array(0 => 'maintenance_deposit_id')));
		$this->addIndex('maintenance_deposit_maintenance_status', 'md_ms2', array('fields' => array(0 => 'maintenance_status_id')));
		
		echo ">> up(): creating patent_deposit_maintenance_status table\n";
		$this->createTable('patent_deposit_maintenance_status', array(
			'patent_deposit_id' => array('type' => 'integer','primary' => '1','length' => '8'),
			'maintenance_status_id' => array('type' => 'integer','primary' => '1','length' => '8'),
			'created_at' => array('notnull' => '1','type' => 'timestamp','length' => '25'),
			'updated_at' => array('notnull' => '1','type' => 'timestamp','length' => '25'),
		), array(
			'type' => 'INNODB',
			'primary' => array(0 => 'patent_deposit_id',1 => 'maintenance_status_id'),
			'collate' => 'utf8_general_ci',
			'charset' => 'utf8',
		));
		$this->createForeignKey('patent_deposit_maintenance_status', 'pppi', array(
			'name' => 'pppi',
			'local' => 'patent_deposit_id',
			'foreign' => 'id',
			'foreignTable' => 'patent_deposit',
			'onUpdate' => '',
			'onDelete' => 'cascade',
		));
		$this->createForeignKey('patent_deposit_maintenance_status', 'pmmi', array(
			'name' => 'pmmi',
			'local' => 'maintenance_status_id',
			'foreign' => 'id',
			'foreignTable' => 'maintenance_status',
		));
		$this->addIndex('patent_deposit_maintenance_status', 'patent_deposit_maintenance_status_patent_deposit_id', array('fields' => array(0 => 'patent_deposit_id',),));
		$this->addIndex('patent_deposit_maintenance_status', 'patent_deposit_maintenance_status_maintenance_status_id', array('fields' => array(0 => 'maintenance_status_id',),));
	}
	
	public function postUp() {
		echo ">> postUp(): initializing strain_maintenance_status table\n";
		foreach ( $this->strains as $strain ) {
			$strainMaintenanceStatus = new StrainMaintenanceStatus();
			$strainMaintenanceStatus->setStrainId($strain['id']);
			$strainMaintenanceStatus->setMaintenanceStatusId($strain['maintenance_status_id']);
			if ( $strainMaintenanceStatus->trySave() ) {
				echo ">> postUp(): strain {$strain['id']}\n";
				echo ">> postUp(): maintenance status {$strain['maintenance_status_id']}\n";
			}
		}
		
		echo ">> postUp(): initializing maintenance_deposit_maintenance_status table\n";
		foreach ( $this->maintenanceDeposits as $deposit ) {
			$maintenanceDepositMaintenanceStatus = new MaintenanceDepositMaintenanceStatus();
			$maintenanceDepositMaintenanceStatus->setMaintenanceDepositId($deposit['id']);
			$maintenanceDepositMaintenanceStatus->setMaintenanceStatusId($deposit['maintenance_status_id']);
			if ( $maintenanceDepositMaintenanceStatus->trySave() ) {
				echo ">> postUp(): maintenance deposit {$deposit['id']}\n";
				echo ">> postUp(): maintenance status {$deposit['maintenance_status_id']}\n";
			}
		}
		
		echo ">> postUp(): initializing patent_deposit_maintenance_status table\n";
		foreach ( $this->patentDeposits as $deposit ) {
			$patentDepositMaintenanceStatus = new PatentDepositMaintenanceStatus();
			$patentDepositMaintenanceStatus->setPatentDepositId($deposit['id']);
			$patentDepositMaintenanceStatus->setMaintenanceStatusId($deposit['maintenance_status_id']);
			if ( $patentDepositMaintenanceStatus->trySave() ) {
				echo ">> postUp(): patent deposit {$deposit['id']}\n";
				echo ">> postUp(): maintenance status {$deposit['maintenance_status_id']}\n";
			}
		}
	}
	
	public function preDown() {
		$this->strainMaintenanceStatus = Doctrine_Core::getTable('StrainMaintenanceStatus')->findAll();
		$this->maintenanceDepositMaintenanceStatus = Doctrine_Core::getTable('MaintenanceDepositMaintenanceStatus')->findAll();
		$this->patentDepositMaintenanceStatus = Doctrine_Core::getTable('PatentDepositMaintenanceStatus')->findAll();
	}
	
	public function down() {
		$this->dropForeignKey('strain_maintenance_status', 'strain_maintenance_status_strain_id_strain_id');
		$this->dropForeignKey('strain_maintenance_status', 'smmi');
		$this->dropForeignKey('maintenance_deposit_maintenance_status', 'mmmi_7');
		$this->dropForeignKey('maintenance_deposit_maintenance_status', 'mmmi_8');
		$this->dropForeignKey('patent_deposit_maintenance_status', 'pppi');
		$this->dropForeignKey('patent_deposit_maintenance_status', 'pmmi');
		
		$this->removeIndex('maintenance_deposit_maintenance_status', 'md_ms1', array('fields' => array(0 => 'maintenance_deposit_id',),));
		$this->removeIndex('maintenance_deposit_maintenance_status', 'md_ms2', array('fields' => array(0 => 'maintenance_status_id',),));
		$this->removeIndex('strain_maintenance_status', 'strain_maintenance_status_strain_id', array('fields' => array(0 => 'strain_id',),));
		$this->removeIndex('strain_maintenance_status', 'strain_maintenance_status_maintenance_status_id', array('fields' => array(0 => 'maintenance_status_id',),));
		$this->removeIndex('patent_deposit_maintenance_status', 'patent_deposit_maintenance_status_patent_deposit_id', array('fields' => array(0 => 'patent_deposit_id',),));
		$this->removeIndex('patent_deposit_maintenance_status', 'patent_deposit_maintenance_status_maintenance_status_id', array('fields' => array(0 => 'maintenance_status_id',),));
		
		$this->dropTable('maintenance_deposit_maintenance_status');
		$this->dropTable('patent_deposit_maintenance_status');
		$this->dropTable('strain_maintenance_status');
		
		$this->addColumn('maintenance_deposit', 'maintenance_status_id', 'integer', '8', array('notnull' => '1'));
		$this->addColumn('patent_deposit', 'maintenance_status_id', 'integer', '8', array('notnull' => '1'));
		$this->addColumn('strain', 'maintenance_status_id', 'integer', '8', array('notnull' => '1'));
		
		$this->createForeignKey('maintenance_deposit', 'maintenance_deposit_maintenance_status_id_maintenance_status_id', array(
			'name' => 'maintenance_deposit_maintenance_status_id_maintenance_status_id',
			'local' => 'maintenance_status_id',
			'foreign' => 'id',
			'foreignTable' => 'maintenance_status',
		));
		$this->createForeignKey('patent_deposit', 'patent_deposit_maintenance_status_id_maintenance_status_id', array(
			'name' => 'patent_deposit_maintenance_status_id_maintenance_status_id',
			'local' => 'maintenance_status_id',
			'foreign' => 'id',
			'foreignTable' => 'maintenance_status',
		));
		$this->createForeignKey('strain', 'strain_maintenance_status_id_maintenance_status_id', array(
			'name' => 'strain_maintenance_status_id_maintenance_status_id',
			'local' => 'maintenance_status_id',
			'foreign' => 'id',
			'foreignTable' => 'maintenance_status',
		));
	}
	
	public function postDown() {
		foreach ( $this->strainMaintenanceStatus as $maintenanceStatus ) {
			$strain = Doctrine_Core::getTable('Strain')->find($maintenanceStatus->getStrainId());
			$strain->setMaintenanceStatusId($maintenanceStatus->getMaintenanceStatusId());
			$strain->trySave();
		}
		
		foreach ( $this->maintenanceDepositMaintenanceStatus as $maintenanceStatus ) {
			$deposit = Doctrine_Core::getTable('MaintenanceDeposit')->find($maintenanceStatus->getMaintenanceDepositId());
			$deposit->setMaintenanceStatusId($maintenanceStatus->getMaintenanceStatusId());
			$deposit->trySave();
		}
	
		foreach ( $this->patentDepositMaintenanceStatus as $maintenanceStatus ) {
			$deposit = Doctrine_Core::getTable('PatentDeposit')->find($maintenanceStatus->getPatentDepositId());
			$deposit->setMaintenanceStatusId($maintenanceStatus->getMaintenanceStatusId());
			$deposit->trySave();
		}
	}
	
}