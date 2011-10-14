<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('maintenance_deposit/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('maintenance_deposit/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'maintenance_deposit/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
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
        <th><?php echo $form['has_dna']->renderLabel() ?></th>
        <td>
          <?php echo $form['has_dna']->renderError() ?>
          <?php echo $form['has_dna'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['gen_sequence']->renderLabel() ?></th>
        <td>
          <?php echo $form['gen_sequence']->renderError() ?>
          <?php echo $form['gen_sequence'] ?>
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
        <th><?php echo $form['collection_date']->renderLabel() ?></th>
        <td>
          <?php echo $form['collection_date']->renderError() ?>
          <?php echo $form['collection_date'] ?>
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
        <th><?php echo $form['identifier_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['identifier_id']->renderError() ?>
          <?php echo $form['identifier_id'] ?>
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
        <th><?php echo $form['depositor_code']->renderLabel() ?></th>
        <td>
          <?php echo $form['depositor_code']->renderError() ?>
          <?php echo $form['depositor_code'] ?>
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
        <th><?php echo $form['viability_test']->renderLabel() ?></th>
        <td>
          <?php echo $form['viability_test']->renderError() ?>
          <?php echo $form['viability_test'] ?>
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
        <th><?php echo $form['mf1_link']->renderLabel() ?></th>
        <td>
          <?php echo $form['mf1_link']->renderError() ?>
          <?php echo $form['mf1_link'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['collectors_list']->renderLabel() ?></th>
        <td>
          <?php echo $form['collectors_list']->renderError() ?>
          <?php echo $form['collectors_list'] ?>
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
