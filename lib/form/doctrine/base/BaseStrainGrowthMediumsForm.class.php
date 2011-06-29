<?php

/**
 * StrainGrowthMediums form base class.
 *
 * @method StrainGrowthMediums getObject() Returns the current form's model object
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseStrainGrowthMediumsForm extends BaseFormDoctrine {
  public function setup() {
    $this->setWidgets(array(
      'strain_id'        => new sfWidgetFormInputHidden(),
      'growth_medium_id' => new sfWidgetFormInputHidden(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'strain_id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('strain_id')), 'empty_value' => $this->getObject()->get('strain_id'), 'required' => false)),
      'growth_medium_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('growth_medium_id')), 'empty_value' => $this->getObject()->get('growth_medium_id'), 'required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('strain_growth_mediums[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName() {
    return 'StrainGrowthMediums';
  }

}
