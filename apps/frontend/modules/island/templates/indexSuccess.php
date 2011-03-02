<?php slot('content_title', 'All islands') ?>
<table id="island_list">
  <thead>
    <tr>
      <th>Name</th>
      <th>Code</th>
      <th>Region</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($islands as $island): ?>
    <tr>
		<td><?php echo link_to($island->getName(), '/settings/island/edit?id='.$island->getId()) ?></td>
		<td><?php echo link_to($island->getCode(), '/settings/island/edit?id='.$island->getId()) ?></td>
		<td><?php echo link_to($island->getRegion()->getName(), '/settings/island/edit?id='.$island->getId()) ?></td>		
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php echo link_to('Add a new island', '/settings/island/new')?>
