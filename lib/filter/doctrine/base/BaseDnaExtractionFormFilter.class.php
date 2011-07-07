<?php

/**
 * DnaExtraction filter form base class.
 *
 * @package    bna_green_house
 * @subpackage filter
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDnaExtractionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'accession_number'     => new sfWidgetFormFilterInput(),
      'filename'             => new sfWidgetFormFilterInput(),
      'strain_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Strain'), 'add_empty' => true)),
      'is_public'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'arrival_date'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'extraction_date'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'extraction_kit_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ExtractionKit'), 'add_empty' => true)),
      'dna_concentration_id' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'aliquots'             => new sfWidgetFormFilterInput(),
      'remarks'              => new sfWidgetFormFilterInput(),
      'created_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'accession_number'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'filename'             => new sfValidatorPass(array('required' => false)),
      'strain_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Strain'), 'column' => 'id')),
      'is_public'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'arrival_date'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'extraction_date'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'extraction_kit_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ExtractionKit'), 'column' => 'id')),
      'dna_concentration_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'aliquots'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'remarks'              => new sfValidatorPass(array('required' => false)),
      'created_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
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
      'id'                   => 'Number',
      'accession_number'     => 'Number',
      'filename'             => 'Text',
      'strain_id'            => 'ForeignKey',
      'is_public'            => 'Boolean',
      'arrival_date'         => 'Date',
      'extraction_date'      => 'Date',
      'extraction_kit_id'    => 'ForeignKey',
      'dna_concentration_id' => 'Number',
      'aliquots'             => 'Number',
      'remarks'              => 'Text',
      'created_at'           => 'Date',
      'updated_at'           => 'Date',
    );
  }
}
