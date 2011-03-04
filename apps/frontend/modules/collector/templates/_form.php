<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php echo form_tag_for($form, '@collector') ?>
<table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo link_to('Back to all collectors', '/settings/collector') ?>
          <?php if (!$form->getObject()->isNew()): ?>
          	<?php echo link_to('Delete', 'collector/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
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
