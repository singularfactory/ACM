<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $cryopreservation->getId() ?></td>
    </tr>
    <tr>
      <th>Subject:</th>
      <td><?php echo $cryopreservation->getSubject() ?></td>
    </tr>
    <tr>
      <th>Strain:</th>
      <td><?php echo $cryopreservation->getStrainId() ?></td>
    </tr>
    <tr>
      <th>Sample:</th>
      <td><?php echo $cryopreservation->getSampleId() ?></td>
    </tr>
    <tr>
      <th>Cryopreservation method:</th>
      <td><?php echo $cryopreservation->getCryopreservationMethodId() ?></td>
    </tr>
    <tr>
      <th>Cryopreservation date:</th>
      <td><?php echo $cryopreservation->getCryopreservationDate() ?></td>
    </tr>
    <tr>
      <th>First replicate:</th>
      <td><?php echo $cryopreservation->getFirstReplicate() ?></td>
    </tr>
    <tr>
      <th>Second replicate:</th>
      <td><?php echo $cryopreservation->getSecondReplicate() ?></td>
    </tr>
    <tr>
      <th>Third replicate:</th>
      <td><?php echo $cryopreservation->getThirdReplicate() ?></td>
    </tr>
    <tr>
      <th>Density:</th>
      <td><?php echo $cryopreservation->getDensity() ?></td>
    </tr>
    <tr>
      <th>Revival date:</th>
      <td><?php echo $cryopreservation->getRevivalDate() ?></td>
    </tr>
    <tr>
      <th>Viability:</th>
      <td><?php echo $cryopreservation->getViability() ?></td>
    </tr>
    <tr>
      <th>Remarks:</th>
      <td><?php echo $cryopreservation->getRemarks() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $cryopreservation->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $cryopreservation->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('cryopreservation/edit?id='.$cryopreservation->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('cryopreservation/index') ?>">List</a>
