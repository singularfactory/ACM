<?php slot('content_title', 'All regions') ?>
<table id="region_list">
  <thead>
    <tr>
      <th>Name</th>
      <th>Code</th>
      <th>Country</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($regions as $region): ?>
    <tr>
      	<td><?php echo link_to($region->getName(), '/settings/region/edit?id='.$region->getId()) ?></td>
		<td><?php echo link_to($region->getCode(), '/settings/region/edit?id='.$region->getId()) ?></td>
		<td><?php echo link_to($region->getCountry()->getName(), '/settings/region/edit?id='.$region->getId()) ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php echo link_to('Add a new region', '/settings/region/new')?>