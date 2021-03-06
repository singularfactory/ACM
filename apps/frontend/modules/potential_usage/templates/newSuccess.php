<?php
/**
 * acm : Algae Culture Management (https://github.com/singularfactory/ACM)
 * Copyright 2012, Singular Factory <info@singularfactory.com>
 *
 * This file is part of ACM
 *
 * ACM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ACM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ACM.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright     Copyright 2012, Singular Factory <info@singularfactory.com>
 * @package       ACM.Frontend
 * @since         1.2
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */
?>
<?php use_helper('CrossAppLink') ?>

<?php slot('main_header', 'Add a new potential usage') ?>
<?php
if (!$hasTaxonomicClasses)
	echo '<p>You must '.link_to('add a taxonomic class', link_to_backend('taxonomic_class_new')).' first before adding potential usages.</p>';
elseif (!$hasGenus)
	echo '<p>You must '.link_to('add a genus', link_to_backend('genus_new')).' first before adding potential usages.</p>';
elseif (!$hasSpecies)
	echo '<p>You must '.link_to('add a species', link_to_backend('species_new')).' first before adding potential usages.</p>';
else
	include_partial('form', array('form' => $form, 'usageAreas' => $usageAreas));
?>

