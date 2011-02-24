<?php

/**
 * Habitat form.
 *
 * @package    bna_green_house
 * @subpackage form
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class HabitatForm extends BaseHabitatForm
{
  public function configure()
  {
	// Hide widgets
	unset($this['created_at'], $this['updated_at']);
  }
}
