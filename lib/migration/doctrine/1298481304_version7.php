<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version7 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('ecosystem_picture', 'ecosystem_picture_ecosystem_id_ecosystem_id', array(
             'name' => 'ecosystem_picture_ecosystem_id_ecosystem_id',
             'local' => 'ecosystem_id',
             'foreign' => 'id',
             'foreignTable' => 'ecosystem',
             'onUpdate' => '',
             'onDelete' => 'cascade',
             ));
        $this->addIndex('ecosystem_picture', 'ecosystem_picture_ecosystem_id', array(
             'fields' => 
             array(
              0 => 'ecosystem_id',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('ecosystem_picture', 'ecosystem_picture_ecosystem_id_ecosystem_id');
        $this->removeIndex('ecosystem_picture', 'ecosystem_picture_ecosystem_id', array(
             'fields' => 
             array(
              0 => 'ecosystem_id',
             ),
             ));
    }
}