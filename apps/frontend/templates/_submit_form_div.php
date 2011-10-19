<?php if ( isset($form) && isset($module) ): ?>

	<?php if ( !isset($add) ) $add = true ?>
	<?php if ( !isset($progressBar) ) $progressBar = false ?>
	<?php $route = "@$module" ?>
	
	<div class="submit">
		<?php if ( $form->getObject()->isNew() ): ?>
			<input type="submit" value="Create this isolation">
			
			<?php if ( $add ): ?><input type="submit" name="_save_and_add" value="Create and add"><?php endif ?>
			
		<?php else: ?>
			<?php $route = sprintf('@%s_show?id=%d', $module, $form->getObject()->getId()) ?>
			<input type="submit" value="Save changes">
		<?php endif; ?>	

		or <?php echo link_to('cancel', $route, array('class' => 'cancel_form_link')) ?>
		
		<?php if ( $progressBar ) echo progress_bar(); ?>
	</div>

<?php endif ?>