<h1>Maintenance deposits List</h1>

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
      <th>Is public</th>
      <th>Has dna</th>
      <th>Gen sequence</th>
      <th>Location</th>
      <th>Environment</th>
      <th>Habitat</th>
      <th>Collection date</th>
      <th>Isolation date</th>
      <th>Identifier</th>
      <th>Depositor</th>
      <th>Deposition date</th>
      <th>Depositor code</th>
      <th>Maintenance status</th>
      <th>Cryopreservation method</th>
      <th>Transfer interval</th>
      <th>Viability test</th>
      <th>Observation</th>
      <th>Citations</th>
      <th>Remarks</th>
      <th>Mf1 link</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($maintenance_deposits as $maintenance_deposit): ?>
    <tr>
      <td><a href="<?php echo url_for('maintenance_deposit/show?id='.$maintenance_deposit->getId()) ?>"><?php echo $maintenance_deposit->getId() ?></a></td>
      <td><?php echo $maintenance_deposit->getTaxonomicClassId() ?></td>
      <td><?php echo $maintenance_deposit->getGenusId() ?></td>
      <td><?php echo $maintenance_deposit->getSpeciesId() ?></td>
      <td><?php echo $maintenance_deposit->getAuthorityId() ?></td>
      <td><?php echo $maintenance_deposit->getIsEpitype() ?></td>
      <td><?php echo $maintenance_deposit->getIsAxenic() ?></td>
      <td><?php echo $maintenance_deposit->getIsPublic() ?></td>
      <td><?php echo $maintenance_deposit->getHasDna() ?></td>
      <td><?php echo $maintenance_deposit->getGenSequence() ?></td>
      <td><?php echo $maintenance_deposit->getLocationId() ?></td>
      <td><?php echo $maintenance_deposit->getEnvironmentId() ?></td>
      <td><?php echo $maintenance_deposit->getHabitatId() ?></td>
      <td><?php echo $maintenance_deposit->getCollectionDate() ?></td>
      <td><?php echo $maintenance_deposit->getIsolationDate() ?></td>
      <td><?php echo $maintenance_deposit->getIdentifierId() ?></td>
      <td><?php echo $maintenance_deposit->getDepositorId() ?></td>
      <td><?php echo $maintenance_deposit->getDepositionDate() ?></td>
      <td><?php echo $maintenance_deposit->getDepositorCode() ?></td>
      <td><?php echo $maintenance_deposit->getMaintenanceStatusId() ?></td>
      <td><?php echo $maintenance_deposit->getCryopreservationMethodId() ?></td>
      <td><?php echo $maintenance_deposit->getTransferInterval() ?></td>
      <td><?php echo $maintenance_deposit->getViabilityTest() ?></td>
      <td><?php echo $maintenance_deposit->getObservation() ?></td>
      <td><?php echo $maintenance_deposit->getCitations() ?></td>
      <td><?php echo $maintenance_deposit->getRemarks() ?></td>
      <td><?php echo $maintenance_deposit->getMf1Link() ?></td>
      <td><?php echo $maintenance_deposit->getCreatedAt() ?></td>
      <td><?php echo $maintenance_deposit->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('maintenance_deposit/new') ?>">New</a>
