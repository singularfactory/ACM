<?php

/**
 * StrainTaxonomy form base class.
 *
 * @method StrainTaxonomy getObject() Returns the current form's model object
 *
 * @package    ACM
 * @subpackage form
 * @author     
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseStrainTaxonomyForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'taxonomic_class_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomicClass'), 'add_empty' => false)),
      'genus_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Genus'), 'add_empty' => false)),
      'species_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Species'), 'add_empty' => true)),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
      'potential_usages_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'UsageAreaUsageTargets')),
      'strain_taxonomies_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'UsageAreaUsageTargets')),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'taxonomic_class_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomicClass'))),
      'genus_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Genus'))),
      'species_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Species'), 'required' => false)),
      'created_at'             => new sfValidatorDateTime(),
      'updated_at'             => new sfValidatorDateTime(),
      'potential_usages_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'UsageAreaUsageTargets', 'required' => false)),
      'strain_taxonomies_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'UsageAreaUsageTargets', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'StrainTaxonomy', 'column' => array('taxonomic_class_id', 'genus_id', 'species_id')))
    );

    $this->widgetSchema->setNameFormat('strain_taxonomy[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StrainTaxonomy';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['potential_usages_list']))
    {
      $this->setDefault('potential_usages_list', $this->object->PotentialUsages->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['strain_taxonomies_list']))
    {
      $this->setDefault('strain_taxonomies_list', $this->object->StrainTaxonomies->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->savePotentialUsagesList($con);
    $this->saveStrainTaxonomiesList($con);

    parent::doSave($con);
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

}
