<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $project->getId() ?></td>
    </tr>
    <tr>
      <th>Strain:</th>
      <td><?php echo $project->getStrainId() ?></td>
    </tr>
    <tr>
      <th>Amount:</th>
      <td><?php echo $project->getAmount() ?></td>
    </tr>
    <tr>
      <th>Provider:</th>
      <td><?php echo $project->getProviderId() ?></td>
    </tr>
    <tr>
      <th>Inoculation date:</th>
      <td><?php echo $project->getInoculationDate() ?></td>
    </tr>
    <tr>
      <th>Purpose:</th>
      <td><?php echo $project->getPurpose() ?></td>
    </tr>
    <tr>
      <th>Delivery date:</th>
      <td><?php echo $project->getDeliveryDate() ?></td>
    </tr>
    <tr>
      <th>Remarks:</th>
      <td><?php echo $project->getRemarks() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $project->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $project->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('project/edit?id='.$project->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('project/index') ?>">List</a>
