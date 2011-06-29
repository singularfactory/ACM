<?php

/**
 * sfGuardUser filter form.
 *
 * @package    bna_green_house
 * @subpackage filter
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrinePluginFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardUserFormFilter extends PluginsfGuardUserFormFilter {
  public function configure() {
	$this->useFields(array('username', 'first_name', 'email_address'));
	
	$this->setWidget('first_name', new sfWidgetFormFilterInput(array('with_empty' => false)));
	
	$this->widgetSchema->setLabel('first_name', 'Name');
	$this->widgetSchema->setLabel('email_address', 'Email');
  }
}
