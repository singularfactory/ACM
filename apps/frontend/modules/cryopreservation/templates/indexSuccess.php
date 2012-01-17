<h1>Cryopreservations List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Subject</th>
      <th>Strain</th>
      <th>Sample</th>
      <th>Cryopreservation method</th>
      <th>Cryopreservation date</th>
      <th>First replicate</th>
      <th>Second replicate</th>
      <th>Third replicate</th>
      <th>Density</th>
      <th>Revival date</th>
      <th>Viability</th>
      <th>Remarks</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($cryopreservations as $cryopreservation): ?>
    <tr>
      <td><a href="<?php echo url_for('cryopreservation/show?id='.$cryopreservation->getId()) ?>"><?php echo $cryopreservation->getId() ?></a></td>
      <td><?php echo $cryopreservation->getSubject() ?></td>
      <td><?php echo $cryopreservation->getStrainId() ?></td>
      <td><?php echo $cryopreservation->getSampleId() ?></td>
      <td><?php echo $cryopreservation->getCryopreservationMethodId() ?></td>
      <td><?php echo $cryopreservation->getCryopreservationDate() ?></td>
      <td><?php echo $cryopreservation->getFirstReplicate() ?></td>
      <td><?php echo $cryopreservation->getSecondReplicate() ?></td>
      <td><?php echo $cryopreservation->getThirdReplicate() ?></td>
      <td><?php echo $cryopreservation->getDensity() ?></td>
      <td><?php echo $cryopreservation->getRevivalDate() ?></td>
      <td><?php echo $cryopreservation->getViability() ?></td>
      <td><?php echo $cryopreservation->getRemarks() ?></td>
      <td><?php echo $cryopreservation->getCreatedAt() ?></td>
      <td><?php echo $cryopreservation->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('cryopreservation/new') ?>">New</a>
