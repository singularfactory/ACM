<?php slot('content_title', 'All radiation types') ?>
<table id="radiation_list">
  <thead>
    <tr>
      <th>Name</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($radiations as $radiation): ?>
    <tr>
      <td><?php echo link_to($radiation->getName(), '/settings/radiation/edit?id='.$radiation->getId()) ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php echo link_to('Add a new radiation type', '/settings/radiation/new')?>