<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $strain->getId() ?></td>
    </tr>
    <tr>
      <th>Sample:</th>
      <td><?php echo $strain->getSampleId() ?></td>
    </tr>
    <tr>
      <th>Dna:</th>
      <td><?php echo $strain->getDnaId() ?></td>
    </tr>
    <tr>
      <th>Has dna:</th>
      <td><?php echo $strain->getHasDna() ?></td>
    </tr>
    <tr>
      <th>Is epitype:</th>
      <td><?php echo $strain->getIsEpitype() ?></td>
    </tr>
    <tr>
      <th>Is axenic:</th>
      <td><?php echo $strain->getIsAxenic() ?></td>
    </tr>
    <tr>
      <th>Is public:</th>
      <td><?php echo $strain->getIsPublic() ?></td>
    </tr>
    <tr>
      <th>Taxonomic class:</th>
      <td><?php echo $strain->getTaxonomicClassId() ?></td>
    </tr>
    <tr>
      <th>Genus:</th>
      <td><?php echo $strain->getGenusId() ?></td>
    </tr>
    <tr>
      <th>Species:</th>
      <td><?php echo $strain->getSpeciesId() ?></td>
    </tr>
    <tr>
      <th>Authority:</th>
      <td><?php echo $strain->getAuthorityId() ?></td>
    </tr>
    <tr>
      <th>Isolator:</th>
      <td><?php echo $strain->getIsolatorId() ?></td>
    </tr>
    <tr>
      <th>Isolation date:</th>
      <td><?php echo $strain->getIsolationDate() ?></td>
    </tr>
    <tr>
      <th>Depositor:</th>
      <td><?php echo $strain->getDepositorId() ?></td>
    </tr>
    <tr>
      <th>Depositor date:</th>
      <td><?php echo $strain->getDepositorDate() ?></td>
    </tr>
    <tr>
      <th>Identifier:</th>
      <td><?php echo $strain->getIdentifierId() ?></td>
    </tr>
    <tr>
      <th>Identification date:</th>
      <td><?php echo $strain->getIdentificationDate() ?></td>
    </tr>
    <tr>
      <th>Maintenance status:</th>
      <td><?php echo $strain->getMaintenanceStatusId() ?></td>
    </tr>
    <tr>
      <th>Cryopreservation method:</th>
      <td><?php echo $strain->getCryopreservationMethodId() ?></td>
    </tr>
    <tr>
      <th>Transfer interval:</th>
      <td><?php echo $strain->getTransferInterval() ?></td>
    </tr>
    <tr>
      <th>Observation:</th>
      <td><?php echo $strain->getObservation() ?></td>
    </tr>
    <tr>
      <th>Citations:</th>
      <td><?php echo $strain->getCitations() ?></td>
    </tr>
    <tr>
      <th>Remarks:</th>
      <td><?php echo $strain->getRemarks() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $strain->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $strain->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('strain/edit?id='.$strain->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('strain/index') ?>">List</a>
