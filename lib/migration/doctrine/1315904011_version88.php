<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version88 extends Doctrine_Migration_Base {
	
	protected $samples = array();
	
	protected $sampleCollectors = array();
	
	public function preUp() {
		echo ">> preUp() found ";
		
		$sampleTable = Doctrine_Core::getTable('Sample');
		$sampleTable->setColumn('collector_id', 'integer', null, array('type' => 'integer'));
		$this->samples = $sampleTable->findAll()->toArray();

		echo count($this->samples);
		echo " samples\n";
	}
	
	public function up() {
		echo ">> up(): dropping collector_id from sample\n";
		$this->dropForeignKey('sample', 'sample_collector_id_collector_id');
		$this->removeColumn('sample', 'collector_id');
		
		echo ">> up(): creating sample_collectors table\n";
		$this->createTable('sample_collectors', array(
			'sample_id' => array('type' => 'integer','primary' => '1','length' => '8'),
			'collector_id' => array('type' => 'integer','primary' => '1','length' => '8'),
			'created_at' => array('notnull' => '1','type' => 'timestamp','length' => '25'),
			'updated_at' => array('notnull' => '1','type' => 'timestamp','length' => '25'),
		), array(
			'type' => 'INNODB',
			'primary' => array(0 => 'sample_id', 1 => 'collector_id'),
			'collate' => 'utf8_general_ci',
			'charset' => 'utf8',
		));
		$this->createForeignKey('sample_collectors', 'sample_collectors_sample_id_sample_id', array(
			'name' => 'sample_collectors_sample_id_sample_id',
			'local' => 'sample_id',
			'foreign' => 'id',
			'foreignTable' => 'sample',
			'onUpdate' => '',
			'onDelete' => 'cascade',
		));
		$this->createForeignKey('sample_collectors', 'sample_collectors_collector_id_collector_id', array(
			'name' => 'sample_collectors_collector_id_collector_id',
			'local' => 'collector_id',
			'foreign' => 'id',
			'foreignTable' => 'collector',
		));
		$this->addIndex('sample_collectors', 'sample_collectors_sample_id', array('fields' => array(0 => 'sample_id')));
		$this->addIndex('sample_collectors', 'sample_collectors_collector_id', array('fields' => array(0 => 'collector_id')));
	}
	
	public function postUp() {
		echo ">> postUp(): initializing sample_collectors table\n";
		foreach ( $this->samples as $sample ) {
			$sampleCollector = new SampleCollectors();
			$sampleCollector->setSampleId($sample['id']);
			$sampleCollector->setCollectorId($sample['collector_id']);
			if ( $sampleCollector->trySave() ) {
				echo ">> postUp(): sample {$sample['id']}\n";
				echo ">> postUp(): collector {$sample['collector_id']}\n";
			}
		}
	}
	
	public function preDown() {
		$this->sampleCollectors = Doctrine_Core::getTable('SampleCollectors')->findAll();
	}
	
	public function down() {
		$this->dropForeignKey('sample_collectors', 'sample_collectors_sample_id_sample_id');
		$this->dropForeignKey('sample_collectors', 'sample_collectors_collector_id_collector_id');
		$this->removeIndex('sample_collectors', 'sample_collectors_sample_id', array('fields' => array(0 => 'sample_id')));
		$this->removeIndex('sample_collectors', 'sample_collectors_collector_id', array('fields' => array(0 => 'collector_id')));
		$this->dropTable('sample_collectors');
		
		$this->addColumn('sample', 'collector_id', 'integer', '8', array('notnull' => '1'));
		$this->createForeignKey('sample', 'sample_collector_id_collector_id', array(
			'name' => 'sample_collector_id_collector_id',
			'local' => 'collector_id',
			'foreign' => 'id',
			'foreignTable' => 'collector',
		));
	}
	
	public function postDown() {
		foreach ( $this->sampleCollectors as $sampleCollector ) {
			$sample = Doctrine_Core::getTable('Sample')->find($sampleCollector->getSampleId());
			$sample->setCollectorId($sampleCollector->getCollectorId());
			$sample->trySave();
		}
	}
	
}