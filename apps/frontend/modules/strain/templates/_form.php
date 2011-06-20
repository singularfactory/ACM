<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('strain/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('strain/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'strain/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['sample_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['sample_id']->renderError() ?>
          <?php echo $form['sample_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['has_dna']->renderLabel() ?></th>
        <td>
          <?php echo $form['has_dna']->renderError() ?>
          <?php echo $form['has_dna'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['is_epitype']->renderLabel() ?></th>
        <td>
          <?php echo $form['is_epitype']->renderError() ?>
          <?php echo $form['is_epitype'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['is_axenic']->renderLabel() ?></th>
        <td>
          <?php echo $form['is_axenic']->renderError() ?>
          <?php echo $form['is_axenic'] ?>
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
        <th><?php echo $form['taxonomic_class_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['taxonomic_class_id']->renderError() ?>
          <?php echo $form['taxonomic_class_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['genus_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['genus_id']->renderError() ?>
          <?php echo $form['genus_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['species_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['species_id']->renderError() ?>
          <?php echo $form['species_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['authority_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['authority_id']->renderError() ?>
          <?php echo $form['authority_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['isolator_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['isolator_id']->renderError() ?>
          <?php echo $form['isolator_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['isolation_date']->renderLabel() ?></th>
        <td>
          <?php echo $form['isolation_date']->renderError() ?>
          <?php echo $form['isolation_date'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['depositor_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['depositor_id']->renderError() ?>
          <?php echo $form['depositor_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['deposition_date']->renderLabel() ?></th>
        <td>
          <?php echo $form['deposition_date']->renderError() ?>
          <?php echo $form['deposition_date'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['identifier_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['identifier_id']->renderError() ?>
          <?php echo $form['identifier_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['identification_date']->renderLabel() ?></th>
        <td>
          <?php echo $form['identification_date']->renderError() ?>
          <?php echo $form['identification_date'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['maintenance_status_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['maintenance_status_id']->renderError() ?>
          <?php echo $form['maintenance_status_id'] ?>
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
        <th><?php echo $form['transfer_interval']->renderLabel() ?></th>
        <td>
          <?php echo $form['transfer_interval']->renderError() ?>
          <?php echo $form['transfer_interval'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['observation']->renderLabel() ?></th>
        <td>
          <?php echo $form['observation']->renderError() ?>
          <?php echo $form['observation'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['citations']->renderLabel() ?></th>
        <td>
          <?php echo $form['citations']->renderError() ?>
          <?php echo $form['citations'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['remarks']->renderLabel() ?></th>
        <td>
          <?php echo $form['remarks']->renderError() ?>
          <?php echo $form['remarks'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['growth_mediums_list']->renderLabel() ?></th>
        <td>
          <?php echo $form['growth_mediums_list']->renderError() ?>
          <?php echo $form['growth_mediums_list'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
