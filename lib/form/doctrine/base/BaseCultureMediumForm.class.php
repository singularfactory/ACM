<?php

/**
 * CultureMedium form base class.
 *
 * @method CultureMedium getObject() Returns the current form's model object
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCultureMediumForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'name'         => new sfWidgetFormInputText(),
      'description'  => new sfWidgetFormInputText(),
      'link'         => new sfWidgetFormTextarea(),
      'is_public'    => new sfWidgetFormInputCheckbox(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
      'strains_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Strain')),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'         => new sfValidatorString(array('max_length' => 255)),
      'description'  => new sfValidatorString(array('max_length' => 255)),
      'link'         => new sfValidatorString(array('max_length' => 1024)),
      'is_public'    => new sfValidatorBoolean(array('required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
      'strains_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Strain', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('culture_medium[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CultureMedium';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['strains_list']))
    {
      $this->setDefault('strains_list', $this->object->Strains->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveStrainsList($con);

    parent::doSave($con);
  }

  public function saveStrainsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['strains_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Strains->getPrimaryKeys();
    $values = $this->getValue('strains_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Strains', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Strains', array_values($link));
    }
  }

}
