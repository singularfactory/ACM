<h1>Growth mediums List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Name</th>
      <th>Description</th>
      <th>Link</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($growth_mediums as $growth_medium): ?>
    <tr>
      <td><a href="<?php echo url_for('growth_medium/show?id='.$growth_medium->getId()) ?>"><?php echo $growth_medium->getId() ?></a></td>
      <td><?php echo $growth_medium->getName() ?></td>
      <td><?php echo $growth_medium->getDescription() ?></td>
      <td><?php echo $growth_medium->getLink() ?></td>
      <td><?php echo $growth_medium->getCreatedAt() ?></td>
      <td><?php echo $growth_medium->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('growth_medium/new') ?>">New</a>
