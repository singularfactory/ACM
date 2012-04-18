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
<?php use_helper('CrossAppLink') ?>

<?php slot('main_header', 'Add a PCR') ?>
<?php
if ( ! $dnaExtraction )
	echo '<p>Every PCR test must be linked to a DNA extraction.'.link_to('Go to the DNA extractions list', '@dna_extraction').' and choose a extraction.</p>';
elseif ( ! $hasDnaPrimers )
	echo '<p>You must '.link_to('add a DNA primer', link_to_backend('dna_primer_new')).' first before creating PCR tests.</p>';
elseif ( ! $hasDnaPolymeraseKits )
	echo '<p>You must '.link_to('add a DNA polymerase kit', link_to_backend('dna_polymerase_new')).' first before creating PCR tests.</p>';
elseif ( ! $hasPcrPrograms )
	echo '<p>You must '.link_to('add a PCR program', link_to_backend('pcr_program_new')).' first before creating PCR tests.</p>';
else
	include_partial('form', array('form' => $form));
?>