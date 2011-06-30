<?php

/**
 * Strain form base class.
 *
 * @method Strain getObject() Returns the current form's model object
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseStrainForm extends BaseFormDoctrine {
  public function setup() {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'sample_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'), 'add_empty' => false)),
      'is_epitype'                 => new sfWidgetFormInputCheckbox(),
      'is_axenic'                  => new sfWidgetFormInputCheckbox(),
      'is_public'                  => new sfWidgetFormInputCheckbox(),
      'taxonomic_class_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomicClass'), 'add_empty' => false)),
      'genus_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Genus'), 'add_empty' => false)),
      'species_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Species'), 'add_empty' => false)),
      'authority_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Authority'), 'add_empty' => false)),
      'isolator_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Isolator'), 'add_empty' => false)),
      'isolation_date'             => new sfWidgetFormDate(),
      'depositor_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Depositor'), 'add_empty' => true)),
      'deposition_date'            => new sfWidgetFormDate(),
      'identifier_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Identifier'), 'add_empty' => true)),
      'identification_date'        => new sfWidgetFormDate(),
      'maintenance_status_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MaintenanceStatus'), 'add_empty' => false)),
      'cryopreservation_method_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CryopreservationMethod'), 'add_empty' => true)),
      'transfer_interval'          => new sfWidgetFormInputText(),
      'observation'                => new sfWidgetFormTextarea(),
      'citations'                  => new sfWidgetFormTextarea(),
      'remarks'                    => new sfWidgetFormTextarea(),
      'created_at'                 => new sfWidgetFormDateTime(),
      'updated_at'                 => new sfWidgetFormDateTime(),
      'growth_mediums_list'        => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'GrowthMedium')),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'sample_id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Sample'))),
      'is_epitype'                 => new sfValidatorBoolean(array('required' => false)),
      'is_axenic'                  => new sfValidatorBoolean(array('required' => false)),
      'is_public'                  => new sfValidatorBoolean(array('required' => false)),
      'taxonomic_class_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TaxonomicClass'))),
      'genus_id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Genus'))),
      'species_id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Species'))),
      'authority_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Authority'))),
      'isolator_id'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Isolator'))),
      'isolation_date'             => new sfValidatorDate(),
      'depositor_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Depositor'), 'required' => false)),
      'deposition_date'            => new sfValidatorDate(array('required' => false)),
      'identifier_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Identifier'), 'required' => false)),
      'identification_date'        => new sfValidatorDate(array('required' => false)),
      'maintenance_status_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('MaintenanceStatus'))),
      'cryopreservation_method_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CryopreservationMethod'), 'required' => false)),
      'transfer_interval'          => new sfValidatorString(array('max_length' => 40, 'required' => false)),
      'observation'                => new sfValidatorString(array('required' => false)),
      'citations'                  => new sfValidatorString(array('required' => false)),
      'remarks'                    => new sfValidatorString(array('required' => false)),
      'created_at'                 => new sfValidatorDateTime(),
      'updated_at'                 => new sfValidatorDateTime(),
      'growth_mediums_list'        => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'GrowthMedium', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('strain[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName() {
    return 'Strain';
  }

  public function updateDefaultsFromObject() {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['growth_mediums_list'])) {
      $this->setDefault('growth_mediums_list', $this->object->GrowthMediums->getPrimaryKeys());
    }

  }

  protected function doSave($con = null) {
    $this->saveGrowthMediumsList($con);

    parent::doSave($con);
  }

  public function saveGrowthMediumsList($con = null) {
    if (!$this->isValid()) {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['growth_mediums_list'])) {
      // somebody has unset this widget
      return;
    }

    if (null === $con) {
      $con = $this->getConnection();
    }

    $existing = $this->object->GrowthMediums->getPrimaryKeys();
    $values = $this->getValue('growth_mediums_list');
    if (!is_array($values)) {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink)) {
      $this->object->unlink('GrowthMediums', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link)) {
      $this->object->link('GrowthMediums', array_values($link));
    }
  }

}