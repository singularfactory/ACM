<?php slot('main_header') ?>
<span>Report results for <?php echo ( $subject === 'dna_extraction' ) ? 'DNA extraction' : sfInflector::humanize($subject) ?></span>
<div id="main_header_action_back" class="main_header_action">
	<?php echo link_to('Create another report', "@report") ?>
</div>
<?php end_slot() ?>

<?php include_partial('report_conditions', array('modelToGroupBy' => $modelToGroupBy, 'filters' => $filters)) ?>

<?php if ( count($results) ): ?>
	<?php if ( in_array($subject, array('location', 'sample', 'strain', 'dna_extraction')) ): ?>
	<?php include_partial("{$subject}_table", array('results' => $results, 'modelToGroupBy' => $modelToGroupBy, 'filters' => $filters)) ?>
	<?php endif ?>
<?php else: ?>
	<p>There are no results to show.</p>
<?php endif; ?>