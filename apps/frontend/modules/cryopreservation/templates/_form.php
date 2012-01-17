<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('cryopreservation/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('cryopreservation/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'cryopreservation/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['subject']->renderLabel() ?></th>
        <td>
          <?php echo $form['subject']->renderError() ?>
          <?php echo $form['subject'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['strain_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['strain_id']->renderError() ?>
          <?php echo $form['strain_id'] ?>
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
        <th><?php echo $form['cryopreservation_method_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['cryopreservation_method_id']->renderError() ?>
          <?php echo $form['cryopreservation_method_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['cryopreservation_date']->renderLabel() ?></th>
        <td>
          <?php echo $form['cryopreservation_date']->renderError() ?>
          <?php echo $form['cryopreservation_date'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['first_replicate']->renderLabel() ?></th>
        <td>
          <?php echo $form['first_replicate']->renderError() ?>
          <?php echo $form['first_replicate'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['second_replicate']->renderLabel() ?></th>
        <td>
          <?php echo $form['second_replicate']->renderError() ?>
          <?php echo $form['second_replicate'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['third_replicate']->renderLabel() ?></th>
        <td>
          <?php echo $form['third_replicate']->renderError() ?>
          <?php echo $form['third_replicate'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['density']->renderLabel() ?></th>
        <td>
          <?php echo $form['density']->renderError() ?>
          <?php echo $form['density'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['revival_date']->renderLabel() ?></th>
        <td>
          <?php echo $form['revival_date']->renderError() ?>
          <?php echo $form['revival_date'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['viability']->renderLabel() ?></th>
        <td>
          <?php echo $form['viability']->renderError() ?>
          <?php echo $form['viability'] ?>
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
