<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@sample') ?>
<table id="sample_form">
	<tfoot>
		<tr>
			<td colspan="2">
				<?php echo link_to('Back to all samples', 'sample/index') ?>
				<?php if (!$form->getObject()->isNew()): ?>
					&nbsp;<?php echo link_to('Delete', 'sample/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
				<?php endif; ?>
				<input type="submit" value="Save" />
			</td>
		</tr>
	</tfoot>
	<tbody>
		<?php echo $form; ?>
	</tbody>
</table>
</form>
