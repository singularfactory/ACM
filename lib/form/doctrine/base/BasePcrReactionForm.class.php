<?php

/**
 * PcrReaction form base class.
 *
 * @method PcrReaction getObject() Returns the current form's model object
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePcrReactionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'dna_primer_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DnaPrimer'), 'add_empty' => false)),
      'worked'        => new sfWidgetFormInputCheckbox(),
      'pcr_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Pcr'), 'add_empty' => false)),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'dna_primer_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DnaPrimer'))),
      'worked'        => new sfValidatorBoolean(array('required' => false)),
      'pcr_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Pcr'))),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('pcr_reaction[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PcrReaction';
  }

}
