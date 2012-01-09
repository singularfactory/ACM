<?php
/**
* This class has been auto-generated by the Doctrine ORM Framework
*/
class Version138 extends Doctrine_Migration_Base {
	
	public function up() {
		echo ">> up(): creating foreign key on `project_name_id` column in `project` table\n";
		$this->createForeignKey('project', 'project_project_name_id_project_name_id', array(
			'name' => 'project_project_name_id_project_name_id',
			'local' => 'project_name_id',
			'foreign' => 'id',
			'foreignTable' => 'project_name',
		));
		
		echo ">> up(): dropping `name` column from `project` table\n";
		$this->removeColumn('project', 'name');
	}
	
	public function down() {
		$this->dropForeignKey('project', 'project_project_name_id_project_name_id');
		$this->addColumn('project', 'name', 'string', '200', array('notnull' => '1',));
	}

}