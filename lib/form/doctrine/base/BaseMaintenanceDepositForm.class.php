<?php

/**
 * MaintenanceDeposit form base class.
 *
 * @method MaintenanceDeposit getObject() Returns the current form's model object
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMaintenanceDepositForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'taxonomic_class_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomicClass'), 'add_empty' => false)),
      'genus_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Genus'), 'add_empty' => false)),
      'species_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Species'), 'add_empty' => false)),
      'authority_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Authority'), 'add_empty' => false)),
      'is_epitype'                 => new sfWidgetFormInputCheckbox(),
      'is_axenic'                  => new sfWidgetFormInputCheckbox(),
      'has_dna'                    => new sfWidgetFormInputCheckbox(),
      'gen_sequence'               => new sfWidgetFormTextarea(),
      'location_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Location'), 'add_empty' => false)),
      'environment_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Environment'), 'add_empty' => false)),
      'habitat_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Habitat'), 'add_empty' => false)),
      'collection_date'            => new sfWidgetFormDate(),
      'isolation_date'             => new sfWidgetFormDate(),
      'identifier_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Identifier'), 'add_empty' => true)),
      'depositor_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Depositor'), 'add_empty' => false)),
      'deposition_date'            => new sfWidgetFormDate(),
      'depositor_code'             => new sfWidgetFormInputText(),
      'maintenance_status_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MaintenanceStatus'), 'add_empty' => false)),
      'cryopreservation_method_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CryopreservationMethod'), 'add_empty' => true)),
      'transfer_interval'          => new sfWidgetFormInputText(),
      'viability_test'             => new sfWidgetFormTextarea(),
      'observation'                => new sfWidgetFormTextarea(),
      'citations'                  => new sfWidgetFormTextarea(),
      'remarks'                    => new sfWidgetFormTextarea(),
      'mf1_link'                   => new sfWidgetFormTextarea(),
      'created_at'                 => new sfWidgetFormDateTime(),
      'updated_at'                 => new sfWidgetFormDateTime(),
      'collectors_list'            => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Collector')),
      'isolators_list'             => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Isolator')),
      'culture_media_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'CultureMedium')),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'taxonomic_class_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomicClass'))),
      'genus_id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Genus'))),
      'species_id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Species'))),
      'authority_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Authority'))),
      'is_epitype'                 => new sfValidatorBoolean(array('required' => false)),
      'is_axenic'                  => new sfValidatorBoolean(array('required' => false)),
      'has_dna'                    => new sfValidatorBoolean(array('required' => false)),
      'gen_sequence'               => new sfValidatorString(array('max_length' => 256, 'required' => false)),
      'location_id'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Location'))),
      'environment_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Environment'))),
      'habitat_id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Habitat'))),
      'collection_date'            => new sfValidatorDate(array('required' => false)),
      'isolation_date'             => new sfValidatorDate(array('required' => false)),
      'identifier_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Identifier'), 'required' => false)),
      'depositor_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Depositor'))),
      'deposition_date'            => new sfValidatorDate(),
      'depositor_code'             => new sfValidatorString(array('max_length' => 40)),
      'maintenance_status_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('MaintenanceStatus'))),
      'cryopreservation_method_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CryopreservationMethod'), 'required' => false)),
      'transfer_interval'          => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'viability_test'             => new sfValidatorString(array('required' => false)),
      'observation'                => new sfValidatorString(array('required' => false)),
      'citations'                  => new sfValidatorString(array('required' => false)),
      'remarks'                    => new sfValidatorString(array('required' => false)),
      'mf1_link'                   => new sfValidatorString(array('max_length' => 1024)),
      'created_at'                 => new sfValidatorDateTime(),
      'updated_at'                 => new sfValidatorDateTime(),
      'collectors_list'            => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Collector', 'required' => false)),
      'isolators_list'             => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Isolator', 'required' => false)),
      'culture_media_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'CultureMedium', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('maintenance_deposit[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MaintenanceDeposit';
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

  }

  protected function doSave($con = null)
  {
    $this->saveCollectorsList($con);
    $this->saveIsolatorsList($con);
    $this->saveCultureMediaList($con);

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

}
