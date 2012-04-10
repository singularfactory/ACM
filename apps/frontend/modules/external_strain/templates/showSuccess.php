<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $external_strain->getId() ?></td>
    </tr>
    <tr>
      <th>Taxonomic class:</th>
      <td><?php echo $external_strain->getTaxonomicClassId() ?></td>
    </tr>
    <tr>
      <th>Genus:</th>
      <td><?php echo $external_strain->getGenusId() ?></td>
    </tr>
    <tr>
      <th>Species:</th>
      <td><?php echo $external_strain->getSpeciesId() ?></td>
    </tr>
    <tr>
      <th>Authority:</th>
      <td><?php echo $external_strain->getAuthorityId() ?></td>
    </tr>
    <tr>
      <th>Is epitype:</th>
      <td><?php echo $external_strain->getIsEpitype() ?></td>
    </tr>
    <tr>
      <th>Is axenic:</th>
      <td><?php echo $external_strain->getIsAxenic() ?></td>
    </tr>
    <tr>
      <th>Has dna:</th>
      <td><?php echo $external_strain->getHasDna() ?></td>
    </tr>
    <tr>
      <th>Gen sequence:</th>
      <td><?php echo $external_strain->getGenSequence() ?></td>
    </tr>
    <tr>
      <th>Location:</th>
      <td><?php echo $external_strain->getLocationId() ?></td>
    </tr>
    <tr>
      <th>Environment:</th>
      <td><?php echo $external_strain->getEnvironmentId() ?></td>
    </tr>
    <tr>
      <th>Habitat:</th>
      <td><?php echo $external_strain->getHabitatId() ?></td>
    </tr>
    <tr>
      <th>Collection date:</th>
      <td><?php echo $external_strain->getCollectionDate() ?></td>
    </tr>
    <tr>
      <th>Isolation date:</th>
      <td><?php echo $external_strain->getIsolationDate() ?></td>
    </tr>
    <tr>
      <th>Identifier:</th>
      <td><?php echo $external_strain->getIdentifierId() ?></td>
    </tr>
    <tr>
      <th>Supervisor:</th>
      <td><?php echo $external_strain->getSupervisorId() ?></td>
    </tr>
    <tr>
      <th>Cryopreservation method:</th>
      <td><?php echo $external_strain->getCryopreservationMethodId() ?></td>
    </tr>
    <tr>
      <th>Transfer interval:</th>
      <td><?php echo $external_strain->getTransferInterval() ?></td>
    </tr>
    <tr>
      <th>Observation:</th>
      <td><?php echo $external_strain->getObservation() ?></td>
    </tr>
    <tr>
      <th>Citations:</th>
      <td><?php echo $external_strain->getCitations() ?></td>
    </tr>
    <tr>
      <th>Remarks:</th>
      <td><?php echo $external_strain->getRemarks() ?></td>
    </tr>
    <tr>
      <th>Container:</th>
      <td><?php echo $external_strain->getContainerId() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $external_strain->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $external_strain->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('external_strain/edit?id='.$external_strain->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('external_strain/index') ?>">List</a>
