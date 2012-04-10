<h1>External strains List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Taxonomic class</th>
      <th>Genus</th>
      <th>Species</th>
      <th>Authority</th>
      <th>Is epitype</th>
      <th>Is axenic</th>
      <th>Has dna</th>
      <th>Gen sequence</th>
      <th>Location</th>
      <th>Environment</th>
      <th>Habitat</th>
      <th>Collection date</th>
      <th>Isolation date</th>
      <th>Identifier</th>
      <th>Supervisor</th>
      <th>Cryopreservation method</th>
      <th>Transfer interval</th>
      <th>Observation</th>
      <th>Citations</th>
      <th>Remarks</th>
      <th>Container</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($external_strains as $external_strain): ?>
    <tr>
      <td><a href="<?php echo url_for('external_strain/show?id='.$external_strain->getId()) ?>"><?php echo $external_strain->getId() ?></a></td>
      <td><?php echo $external_strain->getTaxonomicClassId() ?></td>
      <td><?php echo $external_strain->getGenusId() ?></td>
      <td><?php echo $external_strain->getSpeciesId() ?></td>
      <td><?php echo $external_strain->getAuthorityId() ?></td>
      <td><?php echo $external_strain->getIsEpitype() ?></td>
      <td><?php echo $external_strain->getIsAxenic() ?></td>
      <td><?php echo $external_strain->getHasDna() ?></td>
      <td><?php echo $external_strain->getGenSequence() ?></td>
      <td><?php echo $external_strain->getLocationId() ?></td>
      <td><?php echo $external_strain->getEnvironmentId() ?></td>
      <td><?php echo $external_strain->getHabitatId() ?></td>
      <td><?php echo $external_strain->getCollectionDate() ?></td>
      <td><?php echo $external_strain->getIsolationDate() ?></td>
      <td><?php echo $external_strain->getIdentifierId() ?></td>
      <td><?php echo $external_strain->getSupervisorId() ?></td>
      <td><?php echo $external_strain->getCryopreservationMethodId() ?></td>
      <td><?php echo $external_strain->getTransferInterval() ?></td>
      <td><?php echo $external_strain->getObservation() ?></td>
      <td><?php echo $external_strain->getCitations() ?></td>
      <td><?php echo $external_strain->getRemarks() ?></td>
      <td><?php echo $external_strain->getContainerId() ?></td>
      <td><?php echo $external_strain->getCreatedAt() ?></td>
      <td><?php echo $external_strain->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('external_strain/new') ?>">New</a>
