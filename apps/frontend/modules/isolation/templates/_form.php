<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('isolation/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('isolation/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'isolation/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['reception_date']->renderLabel() ?></th>
        <td>
          <?php echo $form['reception_date']->renderError() ?>
          <?php echo $form['reception_date'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['isolation_subject']->renderLabel() ?></th>
        <td>
          <?php echo $form['isolation_subject']->renderError() ?>
          <?php echo $form['isolation_subject'] ?>
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
        <th><?php echo $form['strain_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['strain_id']->renderError() ?>
          <?php echo $form['strain_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['external_code']->renderLabel() ?></th>
        <td>
          <?php echo $form['external_code']->renderError() ?>
          <?php echo $form['external_code'] ?>
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
        <th><?php echo $form['location_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['location_id']->renderError() ?>
          <?php echo $form['location_id'] ?>
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
        <th><?php echo $form['delivery_date']->renderLabel() ?></th>
        <td>
          <?php echo $form['delivery_date']->renderError() ?>
          <?php echo $form['delivery_date'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['purification_method_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['purification_method_id']->renderError() ?>
          <?php echo $form['purification_method_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['purification_details']->renderLabel() ?></th>
        <td>
          <?php echo $form['purification_details']->renderError() ?>
          <?php echo $form['purification_details'] ?>
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
        <th><?php echo $form['remarks']->renderLabel() ?></th>
        <td>
          <?php echo $form['remarks']->renderError() ?>
          <?php echo $form['remarks'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['isolators_list']->renderLabel() ?></th>
        <td>
          <?php echo $form['isolators_list']->renderError() ?>
          <?php echo $form['isolators_list'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['culture_media_list']->renderLabel() ?></th>
        <td>
          <?php echo $form['culture_media_list']->renderError() ?>
          <?php echo $form['culture_media_list'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
