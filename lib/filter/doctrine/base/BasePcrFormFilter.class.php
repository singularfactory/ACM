<?php

/**
 * Pcr filter form base class.
 *
 * @package    bna_green_house
 * @subpackage filter
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePcrFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'dna_extraction_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DnaExtraction'), 'add_empty' => true)),
      'dna_primer_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DnaPrimer'), 'add_empty' => true)),
      'dna_polymerase_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DnaPolymerase'), 'add_empty' => true)),
      'concentration'     => new sfWidgetFormFilterInput(),
      '260_280_ratio'     => new sfWidgetFormFilterInput(),
      '260_230_ratio'     => new sfWidgetFormFilterInput(),
      'can_be_sequenced'  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'remarks'           => new sfWidgetFormFilterInput(),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'dna_extraction_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DnaExtraction'), 'column' => 'id')),
      'dna_primer_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DnaPrimer'), 'column' => 'id')),
      'dna_polymerase_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DnaPolymerase'), 'column' => 'id')),
      'concentration'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      '260_280_ratio'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      '260_230_ratio'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'can_be_sequenced'  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'remarks'           => new sfValidatorPass(array('required' => false)),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
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
      'id'                => 'Number',
      'dna_extraction_id' => 'ForeignKey',
      'dna_primer_id'     => 'ForeignKey',
      'dna_polymerase_id' => 'ForeignKey',
      'concentration'     => 'Number',
      '260_280_ratio'     => 'Number',
      '260_230_ratio'     => 'Number',
      'can_be_sequenced'  => 'Boolean',
      'remarks'           => 'Text',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
    );
  }
}
