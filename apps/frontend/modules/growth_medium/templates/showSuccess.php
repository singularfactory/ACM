<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $growth_medium->getId() ?></td>
    </tr>
    <tr>
      <th>Name:</th>
      <td><?php echo $growth_medium->getName() ?></td>
    </tr>
    <tr>
      <th>Description:</th>
      <td><?php echo $growth_medium->getDescription() ?></td>
    </tr>
    <tr>
      <th>Link:</th>
      <td><?php echo $growth_medium->getLink() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $growth_medium->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $growth_medium->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('growth_medium/edit?id='.$growth_medium->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('growth_medium/index') ?>">List</a>
