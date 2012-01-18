<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $identification->getId() ?></td>
    </tr>
    <tr>
      <th>Identification date:</th>
      <td><?php echo $identification->getIdentificationDate() ?></td>
    </tr>
    <tr>
      <th>Sample:</th>
      <td><?php echo $identification->getSampleId() ?></td>
    </tr>
    <tr>
      <th>Petitioner:</th>
      <td><?php echo $identification->getPetitioner() ?></td>
    </tr>
    <tr>
      <th>Sample picture:</th>
      <td><?php echo $identification->getSamplePicture() ?></td>
    </tr>
    <tr>
      <th>Microscopy identification:</th>
      <td><?php echo $identification->getMicroscopyIdentification() ?></td>
    </tr>
    <tr>
      <th>Molecular identification:</th>
      <td><?php echo $identification->getMolecularIdentification() ?></td>
    </tr>
    <tr>
      <th>Request document:</th>
      <td><?php echo $identification->getRequestDocument() ?></td>
    </tr>
    <tr>
      <th>Report document:</th>
      <td><?php echo $identification->getReportDocument() ?></td>
    </tr>
    <tr>
      <th>Remarks:</th>
      <td><?php echo $identification->getRemarks() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $identification->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $identification->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('identification/edit?id='.$identification->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('identification/index') ?>">List</a>
