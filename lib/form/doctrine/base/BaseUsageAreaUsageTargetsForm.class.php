<?php

/**
 * UsageAreaUsageTargets form base class.
 *
 * @method UsageAreaUsageTargets getObject() Returns the current form's model object
 *
 * @package    ACM
 * @subpackage form
 * @author     
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUsageAreaUsageTargetsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'usage_area_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UsageArea'), 'add_empty' => false)),
      'usage_target_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UsageTarget'), 'add_empty' => false)),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
      'strain_taxonomies_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'StrainTaxonomy')),
      'potential_usages_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'StrainTaxonomy')),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'usage_area_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UsageArea'))),
      'usage_target_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UsageTarget'))),
      'created_at'             => new sfValidatorDateTime(),
      'updated_at'             => new sfValidatorDateTime(),
      'strain_taxonomies_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'StrainTaxonomy', 'required' => false)),
      'potential_usages_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'StrainTaxonomy', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'UsageAreaUsageTargets', 'column' => array('usage_area_id', 'usage_target_id')))
    );

    $this->widgetSchema->setNameFormat('usage_area_usage_targets[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UsageAreaUsageTargets';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['strain_taxonomies_list']))
    {
      $this->setDefault('strain_taxonomies_list', $this->object->StrainTaxonomies->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['potential_usages_list']))
    {
      $this->setDefault('potential_usages_list', $this->object->PotentialUsages->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveStrainTaxonomiesList($con);
    $this->savePotentialUsagesList($con);

    parent::doSave($con);
  }

  public function saveStrainTaxonomiesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['strain_taxonomies_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->StrainTaxonomies->getPrimaryKeys();
    $values = $this->getValue('strain_taxonomies_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('StrainTaxonomies', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('StrainTaxonomies', array_values($link));
    }
  }

  public function savePotentialUsagesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['potential_usages_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->PotentialUsages->getPrimaryKeys();
    $values = $this->getValue('potential_usages_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('PotentialUsages', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('PotentialUsages', array_values($link));
    }
  }

}
