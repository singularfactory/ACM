<?php

/**
 * sfGuardPermission filter form.
 *
 * @package    bna_green_house
 * @subpackage filter
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrinePluginFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardPermissionFormFilter extends PluginsfGuardPermissionFormFilter {
  public function configure() {
	$this->useFields(array('name'));
	$this->setWidget('name', new sfWidgetFormFilterInput(array('with_empty' => false)));
  }
}
