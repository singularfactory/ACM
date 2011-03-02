<?php slot('content_title', 'All countries') ?>

<table id="country_list">
  <thead>
    <tr>
      <th>Name</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($countrys as $country): ?>
    <tr>
		<td><?php echo link_to($country->getName(), '/settings/country/edit?id='.$country->getId()) ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php echo link_to('Add a new country', '/settings/country/new')?>
