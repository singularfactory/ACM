<?php use_helper('Text') ?>

<?php slot('main_header') ?>
<span>"<?php echo truncate_text($notification->getMessage(), 30) ?>"</span>
<?php include_partial('global/back_header_action', array('module' => 'inbox')) ?>
<?php include_partial('global/delete_header_action', array('module' => 'inbox', 'id' => $notification->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_data_list">
		<dl>
			<dt>Received:</dt>
			<dd><?php echo $notification->getDate() ?></dd>
			<dt>Message:</dt>
			<dd><?php echo $notification->getMessage() ?></dd>
		</dl>
	</div>
	
	<div class="clear"></div>
</div>
