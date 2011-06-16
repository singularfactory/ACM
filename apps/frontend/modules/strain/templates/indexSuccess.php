<h1>Strains List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Sample</th>
      <th>Dna</th>
      <th>Has dna</th>
      <th>Is epitype</th>
      <th>Is axenic</th>
      <th>Is public</th>
      <th>Taxonomic class</th>
      <th>Genus</th>
      <th>Species</th>
      <th>Authority</th>
      <th>Isolator</th>
      <th>Isolation date</th>
      <th>Depositor</th>
      <th>Depositor date</th>
      <th>Identifier</th>
      <th>Identification date</th>
      <th>Maintenance status</th>
      <th>Cryopreservation method</th>
      <th>Transfer interval</th>
      <th>Observation</th>
      <th>Citations</th>
      <th>Remarks</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($strains as $strain): ?>
    <tr>
      <td><a href="<?php echo url_for('strain/show?id='.$strain->getId()) ?>"><?php echo $strain->getId() ?></a></td>
      <td><?php echo $strain->getSampleId() ?></td>
      <td><?php echo $strain->getDnaId() ?></td>
      <td><?php echo $strain->getHasDna() ?></td>
      <td><?php echo $strain->getIsEpitype() ?></td>
      <td><?php echo $strain->getIsAxenic() ?></td>
      <td><?php echo $strain->getIsPublic() ?></td>
      <td><?php echo $strain->getTaxonomicClassId() ?></td>
      <td><?php echo $strain->getGenusId() ?></td>
      <td><?php echo $strain->getSpeciesId() ?></td>
      <td><?php echo $strain->getAuthorityId() ?></td>
      <td><?php echo $strain->getIsolatorId() ?></td>
      <td><?php echo $strain->getIsolationDate() ?></td>
      <td><?php echo $strain->getDepositorId() ?></td>
      <td><?php echo $strain->getDepositorDate() ?></td>
      <td><?php echo $strain->getIdentifierId() ?></td>
      <td><?php echo $strain->getIdentificationDate() ?></td>
      <td><?php echo $strain->getMaintenanceStatusId() ?></td>
      <td><?php echo $strain->getCryopreservationMethodId() ?></td>
      <td><?php echo $strain->getTransferInterval() ?></td>
      <td><?php echo $strain->getObservation() ?></td>
      <td><?php echo $strain->getCitations() ?></td>
      <td><?php echo $strain->getRemarks() ?></td>
      <td><?php echo $strain->getCreatedAt() ?></td>
      <td><?php echo $strain->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('strain/new') ?>">New</a>
