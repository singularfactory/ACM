<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('ecosystem/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('ecosystem/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'ecosystem/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['name']->renderLabel() ?></th>
        <td>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['latitude_degrees']->renderLabel() ?></th>
        <td>
          <?php echo $form['latitude_degrees']->renderError() ?>
          <?php echo $form['latitude_degrees'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['longitude_degrees']->renderLabel() ?></th>
        <td>
          <?php echo $form['longitude_degrees']->renderError() ?>
          <?php echo $form['longitude_degrees'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['latitude_minutes']->renderLabel() ?></th>
        <td>
          <?php echo $form['latitude_minutes']->renderError() ?>
          <?php echo $form['latitude_minutes'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['longitude_minutes']->renderLabel() ?></th>
        <td>
          <?php echo $form['longitude_minutes']->renderError() ?>
          <?php echo $form['longitude_minutes'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['country_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['country_id']->renderError() ?>
          <?php echo $form['country_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['province_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['province_id']->renderError() ?>
          <?php echo $form['province_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['city']->renderLabel() ?></th>
        <td>
          <?php echo $form['city']->renderError() ?>
          <?php echo $form['city'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['picture']->renderLabel() ?></th>
        <td>
          <?php echo $form['picture']->renderError() ?>
          <?php echo $form['picture'] ?>
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
