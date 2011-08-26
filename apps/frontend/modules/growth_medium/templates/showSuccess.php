<?php slot('main_header') ?>
<span>
	<?php echo $growthMedium->getName() ?>
</span>
<?php include_partial('global/back_header_action', array('module' => 'growth_medium')) ?>
<?php include_partial('global/edit_header_action', array('module' => 'growth_medium', 'id' => $growthMedium->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'growth_medium', 'id' => $growthMedium->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_data_list">
		<dl>
			<dt>Name:</dt>
			<dd><?php echo $growthMedium->getName() ?></dd>
			<dt>Link:</dt>
			<dd><?php echo $growthMedium->getLink() ?></dd>
			<dt>Description:</dt>
			<dd><?php echo $growthMedium->getDescription() ?></dd>
			<dt>Is public:</dt>
			<dd><?php echo $growthMedium->getFormattedIsPublic() ?></dd>
			<dt>Amount:</dt>
			<dd><?php echo $growthMedium->getAmount() ?> <?php echo sfConfig::get('app_stock_items_label') ?></dd>
			<dt>Strains:</dt>
			<dd>
				<?php echo $nbStrains = $growthMedium->getNbStrains() ?>
				<?php if ( $nbStrains > 0 ): ?>
					<a href="#growth_medium_strains_list" title="List of strains who used this culture medium" class="page_jump">see below</a>
				<?php endif; ?>
			</dd>
		</dl>
	</div>
	
	<?php if ( $nbStrains > 0): ?>
	<div id="growth_medium_strains_list" class="object_related_model_long_list">
		<h2>Strains</h2>
		<table>
			<tr>
				<th class="code">Code</th>
				<th>Class:</th>
				<th>Genus:</th>
				<th>Species:</th>
			</tr>
			<?php foreach ($growthMedium->getStrains() as $strain ): ?>
			<?php $url = '@strain_show?id='.$strain->getId() ?>
			<tr>
				<td><?php echo link_to($strain->getNumber(), $url) ?></td>
				<td><?php echo link_to($strain->getTaxonomicClass(), $url) ?></td>
				<td><span class="species_name"><?php echo link_to($strain->getGenus(), $url) ?></span></td>
				<td>
					<?php $strainSpecies = $strain->getSpecies() ?>
					<?php if ( $strainSpecies !== sfConfig::get('app_unknown_species_name') ): ?>
					<span class="species_name"><?php echo link_to($strainSpecies, $url) ?></span>
					<?php else: ?>
					<?php echo link_to($strainSpecies, $url) ?>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach ?>
		</table>
	</div>
	<?php endif ?>
	
	<div class="clear"></div>
</div>
