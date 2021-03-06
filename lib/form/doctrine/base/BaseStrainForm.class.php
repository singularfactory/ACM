<?php

/**
 * Strain form base class.
 *
 * @method Strain getObject() Returns the current form's model object
 *
 * @package    ACM
 * @subpackage form
 * @author     
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseStrainForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                       => new sfWidgetFormInputHidden(),
      'code'                     => new sfWidgetFormInputText(),
      'clone_number'             => new sfWidgetFormInputText(),
      'sample_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'add_empty' => true)),
      'depositor_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Depositor'), 'add_empty' => true)),
      'is_epitype'               => new sfWidgetFormInputCheckbox(),
      'is_axenic'                => new sfWidgetFormInputCheckbox(),
      'is_public'                => new sfWidgetFormInputCheckbox(),
      'deceased'                 => new sfWidgetFormInputCheckbox(),
      'kingdom_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Kingdom'), 'add_empty' => true)),
      'subkingdom_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Subkingdom'), 'add_empty' => true)),
      'phylum_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Phylum'), 'add_empty' => true)),
      'taxonomic_class_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomicClass'), 'add_empty' => false)),
      'taxonomic_order_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomicOrder'), 'add_empty' => true)),
      'family_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Family'), 'add_empty' => true)),
      'genus_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Genus'), 'add_empty' => false)),
      'species_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Species'), 'add_empty' => true)),
      'authority_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Authority'), 'add_empty' => false)),
      'isolation_date'           => new sfWidgetFormDate(),
      'identifier_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Identifier'), 'add_empty' => true)),
      'container_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Container'), 'add_empty' => true)),
      'culture_medium_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CultureMedium'), 'add_empty' => true)),
      'transfer_interval'        => new sfWidgetFormInputText(),
      'observation'              => new sfWidgetFormTextarea(),
      'citations'                => new sfWidgetFormTextarea(),
      'web_notes'                => new sfWidgetFormTextarea(),
      'remarks'                  => new sfWidgetFormTextarea(),
      'supervisor_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Supervisor'), 'add_empty' => true)),
      'temperature'              => new sfWidgetFormInputText(),
      'photoperiod'              => new sfWidgetFormInputText(),
      'irradiation'              => new sfWidgetFormInputText(),
      'distribution'             => new sfWidgetFormTextarea(),
      'article_description'      => new sfWidgetFormTextarea(),
      'phylogenetic_description' => new sfWidgetFormTextarea(),
      'phylogenetic_tree'        => new sfWidgetFormInputText(),
      'habitat_description'      => new sfWidgetFormTextarea(),
      'created_at'               => new sfWidgetFormDateTime(),
      'updated_at'               => new sfWidgetFormDateTime(),
      'isolators_list'           => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Isolator')),
      'containers_list'          => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Container')),
      'properties_list'          => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'StrainProperty')),
      'culture_media_list'       => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'CultureMedium')),
      'maintenance_status_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'MaintenanceStatus')),
    ));

    $this->setValidators(array(
      'id'                       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'code'                     => new sfValidatorInteger(),
      'clone_number'             => new sfValidatorInteger(array('required' => false)),
      'sample_id'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'required' => false)),
      'depositor_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Depositor'), 'required' => false)),
      'is_epitype'               => new sfValidatorBoolean(array('required' => false)),
      'is_axenic'                => new sfValidatorBoolean(array('required' => false)),
      'is_public'                => new sfValidatorBoolean(array('required' => false)),
      'deceased'                 => new sfValidatorBoolean(array('required' => false)),
      'kingdom_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Kingdom'), 'required' => false)),
      'subkingdom_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Subkingdom'), 'required' => false)),
      'phylum_id'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Phylum'), 'required' => false)),
      'taxonomic_class_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomicClass'))),
      'taxonomic_order_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomicOrder'), 'required' => false)),
      'family_id'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Family'), 'required' => false)),
      'genus_id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Genus'))),
      'species_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Species'), 'required' => false)),
      'authority_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Authority'))),
      'isolation_date'           => new sfValidatorDate(),
      'identifier_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Identifier'), 'required' => false)),
      'container_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Container'), 'required' => false)),
      'culture_medium_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CultureMedium'), 'required' => false)),
      'transfer_interval'        => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'observation'              => new sfValidatorString(array('required' => false)),
      'citations'                => new sfValidatorString(array('required' => false)),
      'web_notes'                => new sfValidatorString(array('required' => false)),
      'remarks'                  => new sfValidatorString(array('required' => false)),
      'supervisor_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Supervisor'), 'required' => false)),
      'temperature'              => new sfValidatorNumber(array('required' => false)),
      'photoperiod'              => new sfValidatorNumber(array('required' => false)),
      'irradiation'              => new sfValidatorNumber(array('required' => false)),
      'distribution'             => new sfValidatorString(array('required' => false)),
      'article_description'      => new sfValidatorString(array('required' => false)),
      'phylogenetic_description' => new sfValidatorString(array('required' => false)),
      'phylogenetic_tree'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'habitat_description'      => new sfValidatorString(array('required' => false)),
      'created_at'               => new sfValidatorDateTime(),
      'updated_at'               => new sfValidatorDateTime(),
      'isolators_list'           => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Isolator', 'required' => false)),
      'containers_list'          => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Container', 'required' => false)),
      'properties_list'          => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'StrainProperty', 'required' => false)),
      'culture_media_list'       => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'CultureMedium', 'required' => false)),
      'maintenance_status_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'MaintenanceStatus', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Strain', 'column' => array('code', 'clone_number')))
    );

    $this->widgetSchema->setNameFormat('strain[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Strain';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['isolators_list']))
    {
      $this->setDefault('isolators_list', $this->object->Isolators->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['containers_list']))
    {
      $this->setDefault('containers_list', $this->object->Containers->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['properties_list']))
    {
      $this->setDefault('properties_list', $this->object->Properties->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['culture_media_list']))
    {
      $this->setDefault('culture_media_list', $this->object->CultureMedia->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['maintenance_status_list']))
    {
      $this->setDefault('maintenance_status_list', $this->object->MaintenanceStatus->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveIsolatorsList($con);
    $this->saveContainersList($con);
    $this->savePropertiesList($con);
    $this->saveCultureMediaList($con);
    $this->saveMaintenanceStatusList($con);

    parent::doSave($con);
  }

  public function saveIsolatorsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['isolators_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Isolators->getPrimaryKeys();
    $values = $this->getValue('isolators_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Isolators', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Isolators', array_values($link));
    }
  }

  public function saveContainersList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['containers_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Containers->getPrimaryKeys();
    $values = $this->getValue('containers_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Containers', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Containers', array_values($link));
    }
  }

  public function savePropertiesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['properties_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Properties->getPrimaryKeys();
    $values = $this->getValue('properties_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Properties', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Properties', array_values($link));
    }
  }

  public function saveCultureMediaList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['culture_media_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->CultureMedia->getPrimaryKeys();
    $values = $this->getValue('culture_media_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('CultureMedia', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('CultureMedia', array_values($link));
    }
  }

  public function saveMaintenanceStatusList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['maintenance_status_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->MaintenanceStatus->getPrimaryKeys();
    $values = $this->getValue('maintenance_status_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('MaintenanceStatus', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('MaintenanceStatus', array_values($link));
    }
  }

}
