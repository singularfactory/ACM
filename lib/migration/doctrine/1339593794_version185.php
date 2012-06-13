<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version185 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('maintenance_deposit', 'maintenance_deposit_supervisor_id_sf_guard_user_id', array(
             'name' => 'maintenance_deposit_supervisor_id_sf_guard_user_id',
             'local' => 'supervisor_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             ));
/*        $this->addIndex('maintenance_deposit', 'maintenance_deposit_supervisor_id', array(
             'fields' => 
             array(
              0 => 'supervisor_id',
             ),
             ));*/
    }

    public function down()
    {
        $this->dropForeignKey('maintenance_deposit', 'maintenance_deposit_supervisor_id_sf_guard_user_id');
/*        $this->removeIndex('maintenance_deposit', 'maintenance_deposit_supervisor_id', array(
             'fields' => 
             array(
              0 => 'supervisor_id',
             ),
             ));*/
    }
}