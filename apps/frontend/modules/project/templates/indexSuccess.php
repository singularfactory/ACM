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
			<th>Code</th>
			<th><?php echo link_to('Subject', '@project?sort_column=subject&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Name', '@project?sort_column=name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Class', '@project?sort_column=Strain.TaxonomicClass.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Genus', '@project?sort_column=Strain.Genus.name&sort_direction='.$sortDirection) ?></th>
			<th class="date"><?php echo link_to('Inoculation date', '@project?sort_column=inoculation_date&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Petitioner', '@project?sort_column=Petitioner.name&sort_direction='.$sortDirection) ?></th>
			<th class="date"><?php echo link_to('Delivery date', '@project?sort_column=delivery_date&sort_direction='.$sortDirection) ?></th>
			<th></th>
		</tr>
		
		<?php foreach ($pager->getResults() as $project): ?>
		<tr>
			<?php $url = url_for('@project_show?id='.$project->getId()) ?>
			
			<?php $code = '' ?>
			<?php $taxonomicClass = sfConfig::get('app_no_data_message') ?>
			<?php $genusAndSpecies = sfConfig::get('app_no_data_message') ?>
			
			<?php if ( $project->getSubject() == 'sample' ): ?>
				<?php $code = $project->getSample()->getCode() ?>
			<?php elseif ( $project->getSubject() == 'strain' ): ?>
				<?php $strain = $project->getStrain() ?>
				<?php $code = $strain->getFullCode() ?>
				<?php $taxonomicClass = $strain->getTaxonomicClass() ?>
				<?php $genusAndSpecies = $strain->getGenusAndSpecies() ?>
			<?php endif ?>
			
			<td class="project_code"><?php echo link_to($code, $url) ?></td>
			<td class="project_subject"><?php echo link_to($project->getSubject(), $url) ?></td>
			<td class="project_name"><?php echo link_to($project->getName(), $url) ?></td>
			<td class="taxonomic_class_name"><?php echo link_to($taxonomicClass, $url) ?></td>
			<td class="genus_name"><span class="species_name"><?php echo link_to($genusAndSpecies, $url) ?></span></td>
			<td class="date inoculation_date"><?php echo link_to($project->getInoculationDate(), $url) ?></td>
			<td class="petitioner_name"><?php echo link_to($project->getPetitioner()->getName(), $url) ?></td>
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