<h1>Projects List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Strain</th>
      <th>Amount</th>
      <th>Provider</th>
      <th>Inoculation date</th>
      <th>Purpose</th>
      <th>Delivery date</th>
      <th>Remarks</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($projects as $project): ?>
    <tr>
      <td><a href="<?php echo url_for('project/show?id='.$project->getId()) ?>"><?php echo $project->getId() ?></a></td>
      <td><?php echo $project->getStrainId() ?></td>
      <td><?php echo $project->getAmount() ?></td>
      <td><?php echo $project->getProviderId() ?></td>
      <td><?php echo $project->getInoculationDate() ?></td>
      <td><?php echo $project->getPurpose() ?></td>
      <td><?php echo $project->getDeliveryDate() ?></td>
      <td><?php echo $project->getRemarks() ?></td>
      <td><?php echo $project->getCreatedAt() ?></td>
      <td><?php echo $project->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('project/new') ?>">New</a>
