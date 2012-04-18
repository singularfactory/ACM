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
<?php use_helper('Date') ?>

<?php slot('main_header') ?>
<span>All cryopreservations</span>
	<?php include_partial('global/search_box_header_action', array('route' => '@cryopreservation_search?criteria=')) ?>
	<?php include_partial('global/new_header_action', array('message' => 'Add a new cryopreservation', 'route' => '@cryopreservation_new')) ?>
<?php end_slot() ?>

<?php if ( $pager->count() ): ?>
<table id="cryopreservation_list">
	<tbody>
		<tr>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th>Code</th>
			<th><?php echo link_to('Subject', '@cryopreservation?sort_column=subject&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Class', '@cryopreservation?sort_column=Strain.TaxonomicClass.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Genus', '@cryopreservation?sort_column=Strain.Genus.name&sort_direction='.$sortDirection) ?></th>
			<th class="date"><?php echo link_to('Cryopreservation date', '@cryopreservation?sort_column=cryopreservation_date&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Method', '@cryopreservation?sort_column=CryopreservationMethod.name&sort_direction='.$sortDirection) ?></th>
			<th></th>
		</tr>

		<?php foreach ($pager->getResults() as $cryopreservation): ?>
		<tr>
			<?php $url = url_for('@cryopreservation_show?id='.$cryopreservation->getId()) ?>

			<?php $code = '' ?>
			<?php $taxonomicClass = sfConfig::get('app_no_data_message') ?>
			<?php $genusAndSpecies = sfConfig::get('app_no_data_message') ?>
			<?php $subject = $cryopreservation->getSubject() ?>

			<?php if ( $cryopreservation->getSubject() == 'sample' ): ?>
				<?php $code = $cryopreservation->getSample()->getCode() ?>
			<?php elseif ( $cryopreservation->getSubject() == 'strain' ): ?>
				<?php $strain = $cryopreservation->getStrain() ?>
				<?php $code = $strain->getFullCode() ?>
				<?php $taxonomicClass = $strain->getTaxonomicClass() ?>
				<?php $genusAndSpecies = $strain->getGenusAndSpecies() ?>
			<?php elseif ( $cryopreservation->getSubject() == 'external_strain' ): ?>
				<?php $subject = 'research_collection' ?>
				<?php $externalStrain = $cryopreservation->getExternalStrain() ?>
				<?php $code = $externalStrain->getFullCode() ?>
				<?php $taxonomicClass = $externalStrain->getTaxonomicClass() ?>
				<?php $genusAndSpecies = $externalStrain->getGenusAndSpecies() ?>

			<?php endif ?>

			<td class="cryopreservation_code"><?php echo link_to($code, $url) ?></td>
			<td class="cryopreservation_subject"><?php echo link_to(sfInflector::humanize($subject), $url) ?></td>
			<td class="taxonomic_class_name"><?php echo link_to($taxonomicClass, $url) ?></td>
			<td class="genus_name"><span class="species_name"><?php echo link_to($genusAndSpecies, $url) ?></span></td>
			<td class="date cryopreservation_date"><?php echo link_to($cryopreservation->getCryopreservationDate(), $url) ?></td>
			<td class="cryopreservation_method"><?php echo link_to($cryopreservation->getCryopreservationMethod()->getName(), $url) ?></td>

			<td class="actions">
				<a href="<?php echo $url ?>">
					<?php echo link_to('Edit', '@cryopreservation_edit?id='.$cryopreservation->getId()) ?>
					<?php echo link_to('Delete', '@cryopreservation_delete?id='.$cryopreservation->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'cryopreservation', 'sort_direction' => $sortDirection, 'sort_column' => $sortColumn)) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no cryopreservations to show.</p>
<?php endif; ?>