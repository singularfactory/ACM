<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('sample/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
	<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<table id="samples_form">
	<tfoot>
		<tr>
			<td colspan="2">
				<?php echo $form->renderHiddenFields(false) ?>
				&nbsp;<a href="<?php echo url_for('sample/index') ?>">Back to list</a>
				<?php if (!$form->getObject()->isNew()): ?>
					&nbsp;<?php echo link_to('Delete', 'sample/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
				<?php endif; ?>
				<input type="submit" value="Save" />
			</td>
		</tr>
	</tfoot>
	<tbody>
		<?php echo $form->renderGlobalErrors() ?>
		<tr>
			<th><?php echo $form['number']->renderLabel() ?></th>
			<td>
				<?php echo $form['number']->renderError() ?>
				<?php echo $form['number'] ?>
			</td>
		</tr>
		<tr>
			<th><?php echo $form['ecosystem_id']->renderLabel() ?></th>
			<td>
				<?php echo $form['ecosystem_id']->renderError() ?>
				<?php echo $form['ecosystem_id'] ?>
			</td>
		</tr>
		<tr>
			<th><?php echo $form['location']->renderLabel() ?></th>
			<td>
				<?php echo $form['location']->renderError() ?>
				<?php echo $form['location'] ?>
			</td>
		</tr>
		<tr>
			<th><?php echo $form['latitude_degrees']->renderLabel() ?></th>
			<td>
				<?php echo $form['latitude_degrees']->renderError() ?>
				<?php echo $form['latitude_degrees'] ?>
				<span class="form_field_tip">(e.g. 15)</span>
			</td>
		</tr>
		<tr>
			<th><?php echo $form['latitude_minutes']->renderLabel() ?></th>
			<td>
				<?php echo $form['latitude_minutes']->renderError() ?>
				<?php echo $form['latitude_minutes'] ?>
				<span class="form_field_tip">(e.g. 42.14)</span>
			</td>
		</tr>
		<tr>
			<th><?php echo $form['longitude_degrees']->renderLabel() ?></th>
			<td>
				<?php echo $form['longitude_degrees']->renderError() ?>
				<?php echo $form['longitude_degrees'] ?>
				<span class="form_field_tip">(e.g. 15)</span>
			</td>
		</tr>
		<tr>
			<th><?php echo $form['longitude_minutes']->renderLabel() ?></th>
			<td>
				<?php echo $form['longitude_minutes']->renderError() ?>
				<?php echo $form['longitude_minutes'] ?>
				<span class="form_field_tip">(e.g. 42.14)</span>
			</td>
		</tr>
		<tr>
			<th><?php echo $form['environment_id']->renderLabel() ?></th>
			<td>
				<?php echo $form['environment_id']->renderError() ?>
				<?php echo $form['environment_id'] ?>
			</td>
		</tr>
		<tr>
			<th><?php echo $form['habitat_id']->renderLabel() ?></th>
			<td>
				<?php echo $form['habitat_id']->renderError() ?>
				<?php echo $form['habitat_id'] ?>
			</td>
		</tr>
		<tr>
			<th><?php echo $form['ph']->renderLabel() ?></th>
			<td>
				<?php echo $form['ph']->renderError() ?>
				<?php echo $form['ph'] ?>
				<span class="form_field_tip">(e.g. 5.1)</span>
			</td>
		</tr>
		<tr>
			<th><?php echo $form['conductivity']->renderLabel() ?></th>
			<td>
				<?php echo $form['conductivity']->renderError() ?>
				<?php echo $form['conductivity'] ?>
				<span class="form_field_tip">(e.g. 32.3)</span>
			</td>
		</tr>
		<tr>
			<th><?php echo $form['temperature']->renderLabel() ?></th>
			<td>
				<?php echo $form['temperature']->renderError() ?>
				<?php echo $form['temperature'] ?>
				<span class="form_field_tip">(e.g. 15)</span>
			</td>
		</tr>
		<tr>
			<th><?php echo $form['salinity']->renderLabel() ?></th>
			<td>
				<?php echo $form['salinity']->renderError() ?>
				<?php echo $form['salinity'] ?>
				<span class="form_field_tip">(e.g. 3.2)</span>
			</td>
		</tr>
		<tr>
			<th><?php echo $form['close_picture']->renderLabel() ?></th>
			<td>
				<?php echo $form['close_picture']->renderError() ?>
				<?php echo $form['close_picture'] ?>
			</td>
		</tr>
		<tr>
			<th><?php echo $form['laboratory_picture']->renderLabel() ?></th>
			<td>
				<?php echo $form['laboratory_picture']->renderError() ?>
				<?php echo $form['laboratory_picture'] ?>
			</td>
		</tr>
		<tr>
			<th><?php echo $form['collector_id']->renderLabel() ?></th>
			<td>
				<?php echo $form['collector_id']->renderError() ?>
				<?php echo $form['collector_id'] ?>
			</td>
		</tr>
		<tr>
			<th><?php echo $form['collection_date']->renderLabel() ?></th>
			<td>
				<?php echo $form['collection_date']->renderError() ?>
				<?php echo $form['collection_date'] ?>
			</td>
		</tr>
		<tr>
			<th><?php echo $form['remarks']->renderLabel() ?></th>
			<td>
				<?php echo $form['remarks']->renderError() ?>
				<?php echo $form['remarks'] ?>
			</td>
		</tr>
	</tbody>
</table>
</form>
