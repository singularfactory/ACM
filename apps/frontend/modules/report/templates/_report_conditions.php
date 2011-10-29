<div id="report_results_conditions">
<?php if ( $modelToGroupBy ): ?>
	<?php $modelToGroupBy = preg_replace('/^is_/', '', $modelToGroupBy) ?>
	<?php $modelToGroupBy = preg_replace('/^(\d+)_(\d+)_ratio$/', '$1:$2 ratio', $modelToGroupBy) ?>
	<?php $modelToGroupBy = str_replace('_', ' ', $modelToGroupBy) ?>
	
	<span>Results <strong>grouped by <?php echo $modelToGroupBy ?></strong>
	
	<?php if ( count($filters) ): ?>
		and limited to the following conditions:</span>
		<dl>
		<?php foreach ( $filters as $key => $value ): ?>
			<dt>
				<?php
				if ( $key == '260_280_ratio' || $key == '260_230_ratio' ) {
					echo preg_replace('/^(\d+)_(\d+)_ratio$/', '$1:$2 ratio', $key);
				}
				else {
					echo sfInflector::humanize(sfInflector::tableize($key));
				}
				?>:
			</dt>
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
			<dt>
				<?php
				if ( $key == '260_280_ratio' || $key == '260_230_ratio' ) {
					echo preg_replace('/^(\d+)_(\d+)_ratio$/', '$1:$2 ratio', $key);
				}
				else {
					echo sfInflector::humanize(sfInflector::tableize($key));
				}
				?>:
			</dt>
			<dd><?php echo $value ?></dd>
		<?php endforeach ?>
		</dl>
	<?php endif ?>

<?php endif ?>
</div>