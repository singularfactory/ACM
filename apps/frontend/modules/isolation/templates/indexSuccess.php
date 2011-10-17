<h1>Isolations List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Reception date</th>
      <th>Isolation subject</th>
      <th>Sample</th>
      <th>Strain</th>
      <th>External code</th>
      <th>Taxonomic class</th>
      <th>Genus</th>
      <th>Species</th>
      <th>Authority</th>
      <th>Location</th>
      <th>Environment</th>
      <th>Habitat</th>
      <th>Delivery date</th>
      <th>Purification method</th>
      <th>Purification details</th>
      <th>Observation</th>
      <th>Remarks</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($isolations as $isolation): ?>
    <tr>
      <td><a href="<?php echo url_for('isolation/show?id='.$isolation->getId()) ?>"><?php echo $isolation->getId() ?></a></td>
      <td><?php echo $isolation->getReceptionDate() ?></td>
      <td><?php echo $isolation->getIsolationSubject() ?></td>
      <td><?php echo $isolation->getSampleId() ?></td>
      <td><?php echo $isolation->getStrainId() ?></td>
      <td><?php echo $isolation->getExternalCode() ?></td>
      <td><?php echo $isolation->getTaxonomicClassId() ?></td>
      <td><?php echo $isolation->getGenusId() ?></td>
      <td><?php echo $isolation->getSpeciesId() ?></td>
      <td><?php echo $isolation->getAuthorityId() ?></td>
      <td><?php echo $isolation->getLocationId() ?></td>
      <td><?php echo $isolation->getEnvironmentId() ?></td>
      <td><?php echo $isolation->getHabitatId() ?></td>
      <td><?php echo $isolation->getDeliveryDate() ?></td>
      <td><?php echo $isolation->getPurificationMethodId() ?></td>
      <td><?php echo $isolation->getPurificationDetails() ?></td>
      <td><?php echo $isolation->getObservation() ?></td>
      <td><?php echo $isolation->getRemarks() ?></td>
      <td><?php echo $isolation->getCreatedAt() ?></td>
      <td><?php echo $isolation->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('isolation/new') ?>">New</a>
