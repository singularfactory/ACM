<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@ecosystem') ?>
<table id="ecosystem_form">
	<tfoot>
		<tr>
			<td colspan="2">
				&nbsp;<a href="<?php echo url_for('ecosystem/index') ?>">Back to list</a>
				<?php if (!$form->getObject()->isNew()): ?>
					&nbsp;<?php echo link_to('Delete', 'ecosystem/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
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
