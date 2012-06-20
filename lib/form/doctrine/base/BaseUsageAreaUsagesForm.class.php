<?php

/**
 * UsageAreaUsages form base class.
 *
 * @method UsageAreaUsages getObject() Returns the current form's model object
 *
 * @package    ACM
 * @subpackage form
 * @author     
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUsageAreaUsagesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'usage_area_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UsageArea'), 'add_empty' => false)),
      'usage_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PotentialUsage'), 'add_empty' => false)),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'usage_area_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UsageArea'))),
      'usage_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('PotentialUsage'))),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'UsageAreaUsages', 'column' => array('usage_area_id', 'usage_id')))
    );

    $this->widgetSchema->setNameFormat('usage_area_usages[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsageAreaUsages';
  }

}
