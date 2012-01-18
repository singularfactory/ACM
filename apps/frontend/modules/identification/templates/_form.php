<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('identification/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('identification/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'identification/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['identification_date']->renderLabel() ?></th>
        <td>
          <?php echo $form['identification_date']->renderError() ?>
          <?php echo $form['identification_date'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['sample_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['sample_id']->renderError() ?>
          <?php echo $form['sample_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['petitioner']->renderLabel() ?></th>
        <td>
          <?php echo $form['petitioner']->renderError() ?>
          <?php echo $form['petitioner'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['sample_picture']->renderLabel() ?></th>
        <td>
          <?php echo $form['sample_picture']->renderError() ?>
          <?php echo $form['sample_picture'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['microscopy_identification']->renderLabel() ?></th>
        <td>
          <?php echo $form['microscopy_identification']->renderError() ?>
          <?php echo $form['microscopy_identification'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['molecular_identification']->renderLabel() ?></th>
        <td>
          <?php echo $form['molecular_identification']->renderError() ?>
          <?php echo $form['molecular_identification'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['request_document']->renderLabel() ?></th>
        <td>
          <?php echo $form['request_document']->renderError() ?>
          <?php echo $form['request_document'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['report_document']->renderLabel() ?></th>
        <td>
          <?php echo $form['report_document']->renderError() ?>
          <?php echo $form['report_document'] ?>
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
