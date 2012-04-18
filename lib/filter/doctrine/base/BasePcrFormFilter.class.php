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
 * Pcr filter form base class.
 *
 * @package ACM.Lib.Filter
 * @since 1.0
 */
abstract class BasePcrFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'dna_extraction_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DnaExtraction'), 'add_empty' => true)),
      'forward_dna_primer_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ForwardPrimer'), 'add_empty' => true)),
      'reverse_dna_primer_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ReversePrimer'), 'add_empty' => true)),
      'dna_polymerase_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DnaPolymerase'), 'add_empty' => true)),
      'pcr_program_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PcrProgram'), 'add_empty' => true)),
      'concentration'         => new sfWidgetFormFilterInput(),
      '260_280_ratio'         => new sfWidgetFormFilterInput(),
      '260_230_ratio'         => new sfWidgetFormFilterInput(),
      'can_be_sequenced'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'remarks'               => new sfWidgetFormFilterInput(),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'dna_extraction_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DnaExtraction'), 'column' => 'id')),
      'forward_dna_primer_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ForwardPrimer'), 'column' => 'id')),
      'reverse_dna_primer_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ReversePrimer'), 'column' => 'id')),
      'dna_polymerase_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DnaPolymerase'), 'column' => 'id')),
      'pcr_program_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('PcrProgram'), 'column' => 'id')),
      'concentration'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      '260_280_ratio'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      '260_230_ratio'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'can_be_sequenced'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'remarks'               => new sfValidatorPass(array('required' => false)),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('pcr_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Pcr';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'dna_extraction_id'     => 'ForeignKey',
      'forward_dna_primer_id' => 'ForeignKey',
      'reverse_dna_primer_id' => 'ForeignKey',
      'dna_polymerase_id'     => 'ForeignKey',
      'pcr_program_id'        => 'ForeignKey',
      'concentration'         => 'Number',
      '260_280_ratio'         => 'Number',
      '260_230_ratio'         => 'Number',
      'can_be_sequenced'      => 'Boolean',
      'remarks'               => 'Text',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
    );
  }
}
