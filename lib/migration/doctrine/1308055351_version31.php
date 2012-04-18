<?php
/**
 * Migration file
 *
 * acm : Algae Culture Management (https://github.com/singularfactory/ACM)
 * Copyright 2012, Singular Factory <info@singularfactory.com>
 *
 * This file is part of ACM
 *
 * ACM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ACM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ACM.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright     Copyright 2012, Singular Factory <info@singularfactory.com>
 * @package       ACM.Lib.Migration
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version31 extends Doctrine_Migration_Base {
    public function up() {
        $this->createTable('detailed_picture', array(
             'id' =>
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '8',
             ),
             'filename' =>
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '255',
             ),
             'sample_id' =>
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '8',
             ),
             'created_at' =>
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' =>
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'type' => 'INNODB',
             'primary' =>
             array(
              0 => 'id',
             ),
             ));
        $this->createTable('field_picture', array(
             'id' =>
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '8',
             ),
             'filename' =>
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '255',
             ),
             'sample_id' =>
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '8',
             ),
             'created_at' =>
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' =>
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'type' => 'INNODB',
             'primary' =>
             array(
              0 => 'id',
             ),
             ));
        $this->createTable('microscopic_picture', array(
             'id' =>
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '8',
             ),
             'filename' =>
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '255',
             ),
             'sample_id' =>
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '8',
             ),
             'created_at' =>
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' =>
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'type' => 'INNODB',
             'primary' =>
             array(
              0 => 'id',
             ),
             ));
        $this->removeColumn('sample', 'field_picture');
        $this->removeColumn('sample', 'detailed_picture');
        $this->removeColumn('sample', 'microscopic_picture');
    }

    public function down() {
        $this->dropTable('detailed_picture');
        $this->dropTable('field_picture');
        $this->dropTable('microscopic_picture');
        $this->addColumn('sample', 'field_picture', 'string', '255', array(
             ));
        $this->addColumn('sample', 'detailed_picture', 'string', '255', array(
             ));
        $this->addColumn('sample', 'microscopic_picture', 'string', '255', array(
             ));
    }
}