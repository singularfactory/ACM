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
class Addfks extends Doctrine_Migration_Base {
    public function up() {
        $this->createForeignKey('event', 'event_user_id_sf_guard_user_id', array(
             'name' => 'event_user_id_sf_guard_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             ));
        $this->createForeignKey('island', 'island_region_id_region_id', array(
             'name' => 'island_region_id_region_id',
             'local' => 'region_id',
             'foreign' => 'id',
             'foreignTable' => 'region',
             ));
        $this->createForeignKey('location', 'location_country_id_country_id', array(
             'name' => 'location_country_id_country_id',
             'local' => 'country_id',
             'foreign' => 'id',
             'foreignTable' => 'country',
             ));
        $this->createForeignKey('location', 'location_region_id_region_id', array(
             'name' => 'location_region_id_region_id',
             'local' => 'region_id',
             'foreign' => 'id',
             'foreignTable' => 'region',
             ));
        $this->createForeignKey('location', 'location_island_id_island_id', array(
             'name' => 'location_island_id_island_id',
             'local' => 'island_id',
             'foreign' => 'id',
             'foreignTable' => 'island',
             ));
        $this->createForeignKey('location_picture', 'location_picture_location_id_location_id', array(
             'name' => 'location_picture_location_id_location_id',
             'local' => 'location_id',
             'foreign' => 'id',
             'foreignTable' => 'location',
             'onUpdate' => NULL,
             'onDelete' => 'cascade',
             ));
        $this->createForeignKey('region', 'region_country_id_country_id', array(
             'name' => 'region_country_id_country_id',
             'local' => 'country_id',
             'foreign' => 'id',
             'foreignTable' => 'country',
             ));
        $this->createForeignKey('sample', 'sample_location_id_location_id', array(
             'name' => 'sample_location_id_location_id',
             'local' => 'location_id',
             'foreign' => 'id',
             'foreignTable' => 'location',
             ));
        $this->createForeignKey('sample', 'sample_environment_id_environment_id', array(
             'name' => 'sample_environment_id_environment_id',
             'local' => 'environment_id',
             'foreign' => 'id',
             'foreignTable' => 'environment',
             ));
        $this->createForeignKey('sample', 'sample_habitat_id_habitat_id', array(
             'name' => 'sample_habitat_id_habitat_id',
             'local' => 'habitat_id',
             'foreign' => 'id',
             'foreignTable' => 'habitat',
             ));
        $this->createForeignKey('sample', 'sample_radiation_id_radiation_id', array(
             'name' => 'sample_radiation_id_radiation_id',
             'local' => 'radiation_id',
             'foreign' => 'id',
             'foreignTable' => 'radiation',
             ));
        $this->createForeignKey('sample', 'sample_collector_id_collector_id', array(
             'name' => 'sample_collector_id_collector_id',
             'local' => 'collector_id',
             'foreign' => 'id',
             'foreignTable' => 'collector',
             ));
        $this->createForeignKey('sf_guard_forgot_password', 'sf_guard_forgot_password_user_id_sf_guard_user_id', array(
             'name' => 'sf_guard_forgot_password_user_id_sf_guard_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_group_permission', 'sf_guard_group_permission_group_id_sf_guard_group_id', array(
             'name' => 'sf_guard_group_permission_group_id_sf_guard_group_id',
             'local' => 'group_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_group',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_group_permission', 'sf_guard_group_permission_permission_id_sf_guard_permission_id', array(
             'name' => 'sf_guard_group_permission_permission_id_sf_guard_permission_id',
             'local' => 'permission_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_permission',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_remember_key', 'sf_guard_remember_key_user_id_sf_guard_user_id', array(
             'name' => 'sf_guard_remember_key_user_id_sf_guard_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_user_group', 'sf_guard_user_group_user_id_sf_guard_user_id', array(
             'name' => 'sf_guard_user_group_user_id_sf_guard_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_user_group', 'sf_guard_user_group_group_id_sf_guard_group_id', array(
             'name' => 'sf_guard_user_group_group_id_sf_guard_group_id',
             'local' => 'group_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_group',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_user_permission', 'sf_guard_user_permission_user_id_sf_guard_user_id', array(
             'name' => 'sf_guard_user_permission_user_id_sf_guard_user_id',
             'local' => 'user_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
        $this->createForeignKey('sf_guard_user_permission', 'sf_guard_user_permission_permission_id_sf_guard_permission_id', array(
             'name' => 'sf_guard_user_permission_permission_id_sf_guard_permission_id',
             'local' => 'permission_id',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_permission',
             'onUpdate' => NULL,
             'onDelete' => 'CASCADE',
             ));
    }

    public function down() {
        $this->dropForeignKey('event', 'event_user_id_sf_guard_user_id');
        $this->dropForeignKey('island', 'island_region_id_region_id');
        $this->dropForeignKey('location', 'location_country_id_country_id');
        $this->dropForeignKey('location', 'location_region_id_region_id');
        $this->dropForeignKey('location', 'location_island_id_island_id');
        $this->dropForeignKey('location_picture', 'location_picture_location_id_location_id');
        $this->dropForeignKey('region', 'region_country_id_country_id');
        $this->dropForeignKey('sample', 'sample_location_id_location_id');
        $this->dropForeignKey('sample', 'sample_environment_id_environment_id');
        $this->dropForeignKey('sample', 'sample_habitat_id_habitat_id');
        $this->dropForeignKey('sample', 'sample_radiation_id_radiation_id');
        $this->dropForeignKey('sample', 'sample_collector_id_collector_id');
        $this->dropForeignKey('sf_guard_forgot_password', 'sf_guard_forgot_password_user_id_sf_guard_user_id');
        $this->dropForeignKey('sf_guard_group_permission', 'sf_guard_group_permission_group_id_sf_guard_group_id');
        $this->dropForeignKey('sf_guard_group_permission', 'sf_guard_group_permission_permission_id_sf_guard_permission_id');
        $this->dropForeignKey('sf_guard_remember_key', 'sf_guard_remember_key_user_id_sf_guard_user_id');
        $this->dropForeignKey('sf_guard_user_group', 'sf_guard_user_group_user_id_sf_guard_user_id');
        $this->dropForeignKey('sf_guard_user_group', 'sf_guard_user_group_group_id_sf_guard_group_id');
        $this->dropForeignKey('sf_guard_user_permission', 'sf_guard_user_permission_user_id_sf_guard_user_id');
        $this->dropForeignKey('sf_guard_user_permission', 'sf_guard_user_permission_permission_id_sf_guard_permission_id');
    }
}