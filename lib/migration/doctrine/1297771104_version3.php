<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version3 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('ecosystem', 'remarks', 'string', '', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('ecosystem', 'remarks');
    }
}