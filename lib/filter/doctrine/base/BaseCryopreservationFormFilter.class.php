<?php
/**
 * Filter form
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
 * @package       ACM.Lib.Filter
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */


/**
 * Cryopreservation filter form base class.
 *
 * @package ACM.Lib.Filter
 * @since 1.0
 */
abstract class BaseCryopreservationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'subject'                    => new sfWidgetFormChoice(array('choices' => array('' => '', 'sample' => 'sample', 'strain' => 'strain', 'external_strain' => 'external_strain'))),
      'strain_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Strain'), 'add_empty' => true)),
      'sample_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'add_empty' => true)),
      'external_strain_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExternalStrain'), 'add_empty' => true)),
      'cryopreservation_method_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CryopreservationMethod'), 'add_empty' => true)),
      'cryopreservation_date'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'first_replicate'            => new sfWidgetFormFilterInput(),
      'second_replicate'           => new sfWidgetFormFilterInput(),
      'third_replicate'            => new sfWidgetFormFilterInput(),
      'density'                    => new sfWidgetFormFilterInput(),
      'revival_date'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'viability'                  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'remarks'                    => new sfWidgetFormFilterInput(),
      'created_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'subject'                    => new sfValidatorChoice(array('required' => false, 'choices' => array('sample' => 'sample', 'strain' => 'strain', 'external_strain' => 'external_strain'))),
      'strain_id'                  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Strain'), 'column' => 'id')),
      'sample_id'                  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Sample'), 'column' => 'id')),
      'external_strain_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ExternalStrain'), 'column' => 'id')),
      'cryopreservation_method_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CryopreservationMethod'), 'column' => 'id')),
      'cryopreservation_date'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'first_replicate'            => new sfValidatorPass(array('required' => false)),
      'second_replicate'           => new sfValidatorPass(array('required' => false)),
      'third_replicate'            => new sfValidatorPass(array('required' => false)),
      'density'                    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'revival_date'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'viability'                  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'remarks'                    => new sfValidatorPass(array('required' => false)),
      'created_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('cryopreservation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cryopreservation';
  }

  public function getFields()
  {
    return array(
      'id'                         => 'Number',
      'subject'                    => 'Enum',
      'strain_id'                  => 'ForeignKey',
      'sample_id'                  => 'ForeignKey',
      'external_strain_id'         => 'ForeignKey',
      'cryopreservation_method_id' => 'ForeignKey',
      'cryopreservation_date'      => 'Date',
      'first_replicate'            => 'Text',
      'second_replicate'           => 'Text',
      'third_replicate'            => 'Text',
      'density'                    => 'Number',
      'revival_date'               => 'Date',
      'viability'                  => 'Boolean',
      'remarks'                    => 'Text',
      'created_at'                 => 'Date',
      'updated_at'                 => 'Date',
    );
  }
}
