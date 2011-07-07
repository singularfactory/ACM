<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('dna_extraction/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('dna_extraction/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'dna_extraction/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['accession_number']->renderLabel() ?></th>
        <td>
          <?php echo $form['accession_number']->renderError() ?>
          <?php echo $form['accession_number'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['filename']->renderLabel() ?></th>
        <td>
          <?php echo $form['filename']->renderError() ?>
          <?php echo $form['filename'] ?>
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
        <th><?php echo $form['is_public']->renderLabel() ?></th>
        <td>
          <?php echo $form['is_public']->renderError() ?>
          <?php echo $form['is_public'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['arrival_date']->renderLabel() ?></th>
        <td>
          <?php echo $form['arrival_date']->renderError() ?>
          <?php echo $form['arrival_date'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['extraction_date']->renderLabel() ?></th>
        <td>
          <?php echo $form['extraction_date']->renderError() ?>
          <?php echo $form['extraction_date'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['extraction_kit_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['extraction_kit_id']->renderError() ?>
          <?php echo $form['extraction_kit_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['dna_concentration_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['dna_concentration_id']->renderError() ?>
          <?php echo $form['dna_concentration_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['aliquots']->renderLabel() ?></th>
        <td>
          <?php echo $form['aliquots']->renderError() ?>
          <?php echo $form['aliquots'] ?>
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
