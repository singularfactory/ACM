<?php

/**
 * PatentDeposit form base class.
 *
 * @method PatentDeposit getObject() Returns the current form's model object
 *
 * @package    ACM
 * @subpackage form
 * @author     
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePatentDepositForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'depositor_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Depositor'), 'add_empty' => false)),
      'deposition_date'         => new sfWidgetFormDate(),
      'yearly_count'            => new sfWidgetFormInputText(),
      'taxonomic_class_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomicClass'), 'add_empty' => true)),
      'genus_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Genus'), 'add_empty' => true)),
      'species_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Species'), 'add_empty' => true)),
      'authority_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Authority'), 'add_empty' => false)),
      'supervisor_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Supervisor'), 'add_empty' => true)),
      'is_epitype'              => new sfWidgetFormInputCheckbox(),
      'is_axenic'               => new sfWidgetFormInputCheckbox(),
      'has_dna'                 => new sfWidgetFormInputCheckbox(),
      'gen_sequence'            => new sfWidgetFormTextarea(),
      'location_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Location'), 'add_empty' => false)),
      'environment_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Environment'), 'add_empty' => true)),
      'habitat_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Habitat'), 'add_empty' => true)),
      'collection_date'         => new sfWidgetFormDate(),
      'isolation_date'          => new sfWidgetFormDate(),
      'identifier_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Identifier'), 'add_empty' => true)),
      'transfer_interval'       => new sfWidgetFormInputText(),
      'viability_test'          => new sfWidgetFormTextarea(),
      'observation'             => new sfWidgetFormTextarea(),
      'citations'               => new sfWidgetFormTextarea(),
      'remarks'                 => new sfWidgetFormTextarea(),
      'bp1_document'            => new sfWidgetFormInputText(),
      'bp4_document'            => new sfWidgetFormInputText(),
      'picture'                 => new sfWidgetFormInputText(),
      'created_at'              => new sfWidgetFormDateTime(),
      'updated_at'              => new sfWidgetFormDateTime(),
      'collectors_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Collector')),
      'isolators_list'          => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Isolator')),
      'culture_media_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'CultureMedium')),
      'maintenance_status_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'MaintenanceStatus')),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'depositor_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Depositor'))),
      'deposition_date'         => new sfValidatorDate(),
      'yearly_count'            => new sfValidatorInteger(),
      'taxonomic_class_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomicClass'), 'required' => false)),
      'genus_id'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Genus'), 'required' => false)),
      'species_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Species'), 'required' => false)),
      'authority_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Authority'))),
      'supervisor_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Supervisor'), 'required' => false)),
      'is_epitype'              => new sfValidatorBoolean(array('required' => false)),
      'is_axenic'               => new sfValidatorBoolean(array('required' => false)),
      'has_dna'                 => new sfValidatorBoolean(array('required' => false)),
      'gen_sequence'            => new sfValidatorString(array('max_length' => 256, 'required' => false)),
      'location_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Location'))),
      'environment_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Environment'), 'required' => false)),
      'habitat_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Habitat'), 'required' => false)),
      'collection_date'         => new sfValidatorDate(array('required' => false)),
      'isolation_date'          => new sfValidatorDate(array('required' => false)),
      'identifier_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Identifier'), 'required' => false)),
      'transfer_interval'       => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'viability_test'          => new sfValidatorString(array('required' => false)),
      'observation'             => new sfValidatorString(array('required' => false)),
      'citations'               => new sfValidatorString(array('required' => false)),
      'remarks'                 => new sfValidatorString(array('required' => false)),
      'bp1_document'            => new sfValidatorString(array('max_length' => 255)),
      'bp4_document'            => new sfValidatorString(array('max_length' => 255)),
      'picture'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'              => new sfValidatorDateTime(),
      'updated_at'              => new sfValidatorDateTime(),
      'collectors_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Collector', 'required' => false)),
      'isolators_list'          => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Isolator', 'required' => false)),
      'culture_media_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'CultureMedium', 'required' => false)),
      'maintenance_status_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'MaintenanceStatus', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('patent_deposit[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PatentDeposit';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['collectors_list']))
    {
      $this->setDefault('collectors_list', $this->object->Collectors->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['isolators_list']))
    {
      $this->setDefault('isolators_list', $this->object->Isolators->getPrimaryKeys());
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
    $this->saveCollectorsList($con);
    $this->saveIsolatorsList($con);
    $this->saveCultureMediaList($con);
    $this->saveMaintenanceStatusList($con);

    parent::doSave($con);
  }

  public function saveCollectorsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['collectors_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Collectors->getPrimaryKeys();
    $values = $this->getValue('collectors_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Collectors', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Collectors', array_values($link));
    }
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
