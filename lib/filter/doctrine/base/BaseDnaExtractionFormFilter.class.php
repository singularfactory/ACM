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
 * DnaExtraction filter form base class.
 *
 * @package ACM.Lib.Filter
 * @since 1.0
 */
abstract class BaseDnaExtractionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'strain_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Strain'), 'add_empty' => true)),
      'is_public'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'arrival_date'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'extraction_date'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'extraction_kit_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExtractionKit'), 'add_empty' => true)),
      'concentration'     => new sfWidgetFormFilterInput(),
      '260_280_ratio'     => new sfWidgetFormFilterInput(),
      '260_230_ratio'     => new sfWidgetFormFilterInput(),
      'aliquots'          => new sfWidgetFormFilterInput(),
      'genbank_link'      => new sfWidgetFormFilterInput(),
      'remarks'           => new sfWidgetFormFilterInput(),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'strain_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Strain'), 'column' => 'id')),
      'is_public'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'arrival_date'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'extraction_date'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'extraction_kit_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ExtractionKit'), 'column' => 'id')),
      'concentration'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      '260_280_ratio'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      '260_230_ratio'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'aliquots'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'genbank_link'      => new sfValidatorPass(array('required' => false)),
      'remarks'           => new sfValidatorPass(array('required' => false)),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('dna_extraction_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DnaExtraction';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'strain_id'         => 'ForeignKey',
      'is_public'         => 'Boolean',
      'arrival_date'      => 'Date',
      'extraction_date'   => 'Date',
      'extraction_kit_id' => 'ForeignKey',
      'concentration'     => 'Number',
      '260_280_ratio'     => 'Number',
      '260_230_ratio'     => 'Number',
      'aliquots'          => 'Number',
      'genbank_link'      => 'Text',
      'remarks'           => 'Text',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
    );
  }
}
