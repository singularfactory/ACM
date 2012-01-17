<?php use_helper('Date') ?>

<?php slot('main_header') ?>
<span>All isolations</span>
	<?php include_partial('global/search_box_header_action', array('route' => '@isolation_search?criteria=')) ?>
	<?php include_partial('global/new_header_action', array('message' => 'Add a new isolation', 'route' => '@isolation_new')) ?>
<?php end_slot() ?>

<?php if ( $pager->count() ): ?>
<table id="isolation_list">
	<tbody>
		<tr>
			<?php if ( $sortDirection === 'asc' ) $sortDirection = 'desc'; else $sortDirection = 'asc' ?>
			<th>Code</th>
			<th><?php echo link_to('Material', '@isolation?sort_column=isolation_subject&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Class', '@isolation?sort_column=Strain.TaxonomicClass.name&sort_direction='.$sortDirection) ?></th>
			<th><?php echo link_to('Name', '@isolation?sort_column=Strain.Genus.name&sort_direction='.$sortDirection) ?></th>
			<th class="date"><?php echo link_to('Reception date', '@isolation?sort_column=reception_date&sort_direction='.$sortDirection) ?></th>
			<th class="date"><?php echo link_to('Delivery date', '@isolation?sort_column=delivery_date&sort_direction='.$sortDirection) ?></th>
			<th></th>
		</tr>
		
		<?php foreach ($pager->getResults() as $isolation): ?>
		<tr>
			<?php $url = url_for('@isolation_show?id='.$isolation->getId()) ?>
			<?php $code = $isolation->getExternalCode() ?>
			<?php $taxonomicClass = $isolation->getFormattedTaxonomicClass() ?>
			<?php $genusAndSpecies = $isolation->getGenusAndSpecies() ?>
			
			<?php if ( $sample = $isolation->getSample() ): ?>
				<?php $code = $sample->getCode() ?>
			<?php elseif ( $strain = $isolation->getStrain() ): ?>
				<?php $code = $strain->getFullCode() ?>
				<?php $taxonomicClass = $strain->getTaxonomicClass() ?>
				<?php $genusAndSpecies = $strain->getGenusAndSpecies() ?>
			<?php endif ?>
			
			<td class="isolation_code"><?php echo link_to($code, $url) ?></td>
			<td class="isolation_subject"><?php echo link_to($isolation->getIsolationSubject(), $url) ?></td>
			<td class="taxonomic_class_name"><?php echo link_to($taxonomicClass, $url) ?></td>
			<td class="isolation_name"><span class="species_name"><?php echo link_to($genusAndSpecies, $url) ?></span></td>
			<td class="date reception_date"><?php echo link_to($isolation->getReceptionDate(), $url) ?></td>
			<td class="date delivery_date"><?php echo link_to($isolation->getDeliveryDate(), $url) ?></td>

			<td class="actions">
				<a href="<?php echo $url ?>">
					<?php echo link_to('Edit', '@isolation_edit?id='.$isolation->getId()) ?>
					<?php echo link_to('Delete', '@isolation_delete?id='.$isolation->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
	<?php include_partial('global/pagination_info', array('pager' => $pager, 'model' => 'isolation', 'sort_direction' => $sortDirection, 'sort_column' => $sortColumn)) ?>
<?php endif ?>

<?php else: ?>
	<p>There are no isolations to show.</p>
<?php endif; ?>