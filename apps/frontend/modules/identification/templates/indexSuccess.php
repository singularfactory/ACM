<h1>Identifications List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Identification date</th>
      <th>Sample</th>
      <th>Petitioner</th>
      <th>Sample picture</th>
      <th>Microscopy identification</th>
      <th>Molecular identification</th>
      <th>Request document</th>
      <th>Report document</th>
      <th>Remarks</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($identifications as $identification): ?>
    <tr>
      <td><a href="<?php echo url_for('identification/show?id='.$identification->getId()) ?>"><?php echo $identification->getId() ?></a></td>
      <td><?php echo $identification->getIdentificationDate() ?></td>
      <td><?php echo $identification->getSampleId() ?></td>
      <td><?php echo $identification->getPetitioner() ?></td>
      <td><?php echo $identification->getSamplePicture() ?></td>
      <td><?php echo $identification->getMicroscopyIdentification() ?></td>
      <td><?php echo $identification->getMolecularIdentification() ?></td>
      <td><?php echo $identification->getRequestDocument() ?></td>
      <td><?php echo $identification->getReportDocument() ?></td>
      <td><?php echo $identification->getRemarks() ?></td>
      <td><?php echo $identification->getCreatedAt() ?></td>
      <td><?php echo $identification->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('identification/new') ?>">New</a>
