<div id="report_results_conditions">
<?php if ( $modelToGroupBy ): ?>
	<span>Results <strong>grouped by <?php echo $modelToGroupBy ?></strong>
	
	<?php if ( count($filters) ): ?>
		and limited to the following conditions:</span>
		<dl>
		<?php foreach ( $filters as $key => $value ): ?>
			<dt><?php echo $key ?>:</dt>
			<dd><?php echo $value ?></dd>
		<?php endforeach ?>
		</dl>
	<?php else: ?>
		</span>
	<?php endif ?>
</div>

<?php else: ?>

	<?php if ( count($filters) ): ?>
		<span>Results limited to the following conditions:</span>
		<dl>
		<?php foreach ( $filters as $key => $value ): ?>
			<dt><?php echo $key ?>:</dt>
			<dd><?php echo $value ?></dd>
		<?php endforeach ?>
		</dl>
	<?php endif ?>

<?php endif ?>
</div>