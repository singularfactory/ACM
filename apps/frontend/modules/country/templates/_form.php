<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@country') ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo link_to('Back to all countries', '/settings/country') ?>
          <?php if (!$form->getObject()->isNew()): ?>
            <?php echo link_to('Delete', 'country/delete/'.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form ?>
    </tbody>
  </table>
</form>
