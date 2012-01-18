<?php use_helper('Date', 'Thumbnail') ?>

<?php slot('main_header') ?>
<span>Identification request for sample <?php echo $identification->getSample()->getCode() ?></span>
<?php include_partial('global/back_header_action', array('module' => 'identification')) ?>
<?php include_partial('global/edit_header_action', array('module' => 'identification', 'id' => $identification->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'identification', 'id' => $identification->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<?php if ( $filename = $identification->getSamplePicture() ): ?>
	<div id="object_related_models">
		<div class="object_related_model_list">
			<h2>Sample picture</h2>
			<div class="thumbnail">
				<div class="thumbnail_image">
					<a href="<?php echo get_picture_with_path($filename, 'identification') ?>" rel="thumbnail_link" title="Sample picture" class="cboxElement">
						<img src="<?php echo get_thumbnail($filename, 'identification') ?>" alt="Sample picture" />
					</a>
				</div>
			</div>
		</div>		
	</div>
	<?php endif ?>
	
	<div id="object_data_list">
		<dl class="identification">
			<dt>Date:</dt>
			<dd><?php echo $identification->getIdentificationDate() ?></dd>

			<dt>Petitioner:</dt>
			<dd><?php echo $identification->getFormattedPetitioner() ?></dd>

			<dt>Sample:</dt>
			<dd><?php echo $identification->getSample()->getCode() ?></dd>

			<dt>Request document:</dt>
			<dd>
				<?php if ( $url = $identification->getRequestDocumentUrl() ): ?>
				<?php echo link_to($identification->getRequestDocument(), $url) ?>
				<?php else: ?>
				<?php echo sfConfig::get('app_no_data_message') ?>
				<?php endif; ?>
			</dd>

			<dt>Report document:</dt>
			<dd>
				<?php if ( $url = $identification->getReportDocumentUrl() ): ?>
				<?php echo link_to($identificationidentification->getReportDocument(), $url) ?>
				<?php else: ?>
				<?php echo sfConfig::get('app_no_data_message') ?>
				<?php endif; ?>
			</dd>

			<dt>Microscopy identification:</dt>
			<dd><?php echo $identification->getMicroscopyIdentification() ?></dd>
			
			<dt>Molecular identification:</dt>
			<dd><?php echo $identification->getMolecularIdentification() ?></dd>

			<dt>Remarks:</dt>
			<dd><?php echo $identification->getRemarks() ?></dd>
		</dl>
	</div>
	
	<div class="clear"></div>
</div>