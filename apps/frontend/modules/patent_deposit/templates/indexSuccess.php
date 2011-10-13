<h1>Patent deposits List</h1>

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
      <th>Latitude</th>
      <th>Longitude</th>
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
      <th>Bp1 link</th>
      <th>Bp4 link</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($patent_deposits as $patent_deposit): ?>
    <tr>
      <td><a href="<?php echo url_for('patent_deposit/show?id='.$patent_deposit->getId()) ?>"><?php echo $patent_deposit->getId() ?></a></td>
      <td><?php echo $patent_deposit->getTaxonomicClassId() ?></td>
      <td><?php echo $patent_deposit->getGenusId() ?></td>
      <td><?php echo $patent_deposit->getSpeciesId() ?></td>
      <td><?php echo $patent_deposit->getAuthorityId() ?></td>
      <td><?php echo $patent_deposit->getIsEpitype() ?></td>
      <td><?php echo $patent_deposit->getIsAxenic() ?></td>
      <td><?php echo $patent_deposit->getIsPublic() ?></td>
      <td><?php echo $patent_deposit->getHasDna() ?></td>
      <td><?php echo $patent_deposit->getGenSequence() ?></td>
      <td><?php echo $patent_deposit->getLocationId() ?></td>
      <td><?php echo $patent_deposit->getLatitude() ?></td>
      <td><?php echo $patent_deposit->getLongitude() ?></td>
      <td><?php echo $patent_deposit->getEnvironmentId() ?></td>
      <td><?php echo $patent_deposit->getHabitatId() ?></td>
      <td><?php echo $patent_deposit->getCollectionDate() ?></td>
      <td><?php echo $patent_deposit->getIsolationDate() ?></td>
      <td><?php echo $patent_deposit->getIdentifierId() ?></td>
      <td><?php echo $patent_deposit->getDepositorId() ?></td>
      <td><?php echo $patent_deposit->getDepositionDate() ?></td>
      <td><?php echo $patent_deposit->getDepositorCode() ?></td>
      <td><?php echo $patent_deposit->getMaintenanceStatusId() ?></td>
      <td><?php echo $patent_deposit->getCryopreservationMethodId() ?></td>
      <td><?php echo $patent_deposit->getTransferInterval() ?></td>
      <td><?php echo $patent_deposit->getViabilityTest() ?></td>
      <td><?php echo $patent_deposit->getObservation() ?></td>
      <td><?php echo $patent_deposit->getCitations() ?></td>
      <td><?php echo $patent_deposit->getRemarks() ?></td>
      <td><?php echo $patent_deposit->getBp1Link() ?></td>
      <td><?php echo $patent_deposit->getBp4Link() ?></td>
      <td><?php echo $patent_deposit->getCreatedAt() ?></td>
      <td><?php echo $patent_deposit->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('patent_deposit/new') ?>">New</a>
