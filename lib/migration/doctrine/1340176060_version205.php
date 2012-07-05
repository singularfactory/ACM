<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version205 extends Doctrine_Migration_Base {
	public $maintenanceDeposits = array();

	public function preUp() {
		echo ">> preUp() found ";

		$maintenanceDepositTable = Doctrine_Core::getTable('MaintenanceDeposit');
		$maintenanceDepositTable->setColumn('depositor_code', 'string', 40, array('type' => 'string', 'length' => 40));
		$this->maintenanceDeposits = $maintenanceDepositTable->createQuery('p')
			->select('p.id, p.depositor_code')
			->execute(array(), Doctrine_Core::HYDRATE_SCALAR);

		echo count($this->maintenanceDeposits);
		echo " maintenance deposits\n";
	}

	public function up() {
		echo ">> up(): dropping depositor_code from maintenance_deposit\n";
		$this->removeColumn('maintenance_deposit', 'depositor_code');
		echo ">> up(): adding yearly_count to maintenance_deposit\n";
		$this->addColumn('maintenance_deposit', 'yearly_count', 'integer', '8', array('notnull' => '1'));
	}

	public function postUp() {
		echo ">> postUp(): updating maintenance_deposit table\n";
		$maintenanceDepositTable = Doctrine_Core::getTable('MaintenanceDeposit');
		foreach ($this->maintenanceDeposits as $maintenanceDeposit) {
			$code = (int) preg_replace('/^BEAM(\d+)_(\d+)$/', "$1", $maintenanceDeposit['p_depositor_code']);
			echo "{$maintenanceDeposit['p_id']}: from {$maintenanceDeposit['p_depositor_code']} to $code\n";
			$maintenanceDepositTable->createQuery('p')
				->update()
				->set('p.yearly_count', $code)
				->where("p.id = ?", $maintenanceDeposit['p_id'])
				->execute();
		}
	}

	public function down() {
		$this->addColumn('maintenance_deposit', 'depositor_code', 'string', '40', array('notnull' => '1'));
		$this->removeColumn('maintenance_deposit', 'yearly_count');
	}
}