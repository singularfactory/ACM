<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('project/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('project/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'project/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['strain_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['strain_id']->renderError() ?>
          <?php echo $form['strain_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['amount']->renderLabel() ?></th>
        <td>
          <?php echo $form['amount']->renderError() ?>
          <?php echo $form['amount'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['provider_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['provider_id']->renderError() ?>
          <?php echo $form['provider_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['inoculation_date']->renderLabel() ?></th>
        <td>
          <?php echo $form['inoculation_date']->renderError() ?>
          <?php echo $form['inoculation_date'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['purpose']->renderLabel() ?></th>
        <td>
          <?php echo $form['purpose']->renderError() ?>
          <?php echo $form['purpose'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['delivery_date']->renderLabel() ?></th>
        <td>
          <?php echo $form['delivery_date']->renderError() ?>
          <?php echo $form['delivery_date'] ?>
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
