<?php

/**
 * Identification filter form base class.
 *
 * @package    bna_green_house
 * @subpackage filter
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseIdentificationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'identification_date'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'yearly_count'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sample_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'add_empty' => true)),
      'petitioner_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Petitioner'), 'add_empty' => true)),
      'sample_picture'            => new sfWidgetFormFilterInput(),
      'microscopy_identification' => new sfWidgetFormFilterInput(),
      'molecular_identification'  => new sfWidgetFormFilterInput(),
      'request_document'          => new sfWidgetFormFilterInput(),
      'report_document'           => new sfWidgetFormFilterInput(),
      'remarks'                   => new sfWidgetFormFilterInput(),
      'created_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'identification_date'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'yearly_count'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'sample_id'                 => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Sample'), 'column' => 'id')),
      'petitioner_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Petitioner'), 'column' => 'id')),
      'sample_picture'            => new sfValidatorPass(array('required' => false)),
      'microscopy_identification' => new sfValidatorPass(array('required' => false)),
      'molecular_identification'  => new sfValidatorPass(array('required' => false)),
      'request_document'          => new sfValidatorPass(array('required' => false)),
      'report_document'           => new sfValidatorPass(array('required' => false)),
      'remarks'                   => new sfValidatorPass(array('required' => false)),
      'created_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('identification_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Identification';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'identification_date'       => 'Date',
      'yearly_count'              => 'Number',
      'sample_id'                 => 'ForeignKey',
      'petitioner_id'             => 'ForeignKey',
      'sample_picture'            => 'Text',
      'microscopy_identification' => 'Text',
      'molecular_identification'  => 'Text',
      'request_document'          => 'Text',
      'report_document'           => 'Text',
      'remarks'                   => 'Text',
      'created_at'                => 'Date',
      'updated_at'                => 'Date',
    );
  }
}
