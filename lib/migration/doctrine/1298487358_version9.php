<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version9 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn('sample', 'number');
    }

    public function down()
    {
        $this->addColumn('sample', 'number', 'integer', '8', array(
             'notnull' => '1',
             'unique' => '1',
             'unsigned' => '1',
             ));
    }
}