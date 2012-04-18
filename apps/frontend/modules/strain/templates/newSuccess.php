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
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */
?>
<?php use_helper('CrossAppLink', 'Thumbnail', 'PictureUpload') ?>

<?php slot('main_header', 'Add a new strain') ?>
<?php
if ( ! $hasSamples )
	echo '<p>You must '.link_to('add a sample', 'sample/new').' first before creating strains.</p>';
elseif ( ! $hasTaxonomicClasses )
	echo '<p>You must '.link_to('add a taxonomic class', link_to_backend('taxonomic_class_new')).' first before creating strains.</p>';
elseif ( ! $hasGenus )
	echo '<p>You must '.link_to('add a genus', link_to_backend('genus_new')).' first before creating strains.</p>';
elseif ( ! $hasSpecies )
	echo '<p>You must '.link_to('add a species', link_to_backend('species_new')).' first before creating strains.</p>';
elseif ( ! $hasAuthorities )
	echo '<p>You must '.link_to('add an authority', link_to_backend('authority_new')).' first before creating strains.</p>';
elseif ( ! $hasIsolators )
	echo '<p>You must '.link_to('add an isolator', link_to_backend('isolator_new')).' first before creating strains.</p>';
elseif ( ! $hasCultureMedia )
	echo '<p>You must '.link_to('add a culture medium', '@culture_medium_new').' first before creating strains.</p>';
else
	include_partial('form', array('form' => $form, 'sampleCode' => $sampleCode));
?>