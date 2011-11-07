<?php use_helper('Date') ?>

<?php slot('main_header') ?>
<span>All projects</span>
	<?php include_partial('global/search_box_header_action', array('route' => '@project_search?criteria=')) ?>
	<?php include_partial('global/new_header_action', array('message' => 'Add a new project', 'route' => '@project_new')) ?>
<?php end_slot() ?>

<?php if ( $pager->count() ): ?>
<table id="project_list">
	<tbody>
		<tr>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th><?php echo link_to('Strain', '@project?sort_column=Strain.id&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Class', '@project?sort_column=Strain.TaxonomicClass.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Name', '@project?sort_column=Strain.Genus.name&sort_direction='.$sortDirection) ?></th>
			<th class="date"><?php echo link_to('Inoculation date', '@project?sort_column=inoculation_date&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Provider', '@project?sort_column=Provider.name&sort_direction='.$sortDirection) ?></th>
			<th class="date"><?php echo link_to('Delivery date', '@project?sort_column=delivery_date&sort_direction='.$sortDirection) ?></th>
			<th></th>
		</tr>
		
		<?php foreach ($pager->getResults() as $project): ?>
		<tr>
			<?php $url = url_for('@project_show?id='.$project->getId()) ?>
			<?php $strain = $project->getStrain() ?>
			<td class="project_strain_code"><?php echo link_to($strain->getFullCode(), $url) ?></td>
			<td class="taxonomic_class_name"><?php echo link_to($strain->getTaxonomicClass(), $url) ?></td>
			<?php
				$strainName = '<span class="species_name">'.$strain->getGenus().'</span>&nbsp;';
				if ( $strain->getSpecies() !== sfConfig::get('app_unknown_species_name') ) {
					$strainName .= '<span class="species_name">'.$strain->getSpecies().'</span>';
				}
				else {
					$strainName .= $strain->getSpecies();
				}
			?>
			<td class="project_name"><?php echo link_to($strainName, $url) ?></td>
			<td class="date inoculation_date"><?php echo link_to($project->getInoculationDate(), $url) ?></td>
			<td class="provider_name"><?php echo link_to($project->getProvider()->getName(), $url) ?></td>
			<td class="date delivery_date"><?php echo link_to($project->getDeliveryDate(), $url) ?></td>

			<td class="actions">
				<a href="<?php echo $url ?>">
					<?php echo link_to('Edit', '@project_edit?id='.$project->getId()) ?>
					<?php echo link_to('Delete', '@project_delete?id='.$project->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'project')) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no projects to show.</p>
<?php endif; ?>