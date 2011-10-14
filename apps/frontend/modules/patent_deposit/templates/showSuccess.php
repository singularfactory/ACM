<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $patent_deposit->getId() ?></td>
    </tr>
    <tr>
      <th>Taxonomic class:</th>
      <td><?php echo $patent_deposit->getTaxonomicClassId() ?></td>
    </tr>
    <tr>
      <th>Genus:</th>
      <td><?php echo $patent_deposit->getGenusId() ?></td>
    </tr>
    <tr>
      <th>Species:</th>
      <td><?php echo $patent_deposit->getSpeciesId() ?></td>
    </tr>
    <tr>
      <th>Authority:</th>
      <td><?php echo $patent_deposit->getAuthorityId() ?></td>
    </tr>
    <tr>
      <th>Is epitype:</th>
      <td><?php echo $patent_deposit->getIsEpitype() ?></td>
    </tr>
    <tr>
      <th>Is axenic:</th>
      <td><?php echo $patent_deposit->getIsAxenic() ?></td>
    </tr>
    <tr>
      <th>Is public:</th>
      <td><?php echo $patent_deposit->getIsPublic() ?></td>
    </tr>
    <tr>
      <th>Has dna:</th>
      <td><?php echo $patent_deposit->getHasDna() ?></td>
    </tr>
    <tr>
      <th>Gen sequence:</th>
      <td><?php echo $patent_deposit->getGenSequence() ?></td>
    </tr>
    <tr>
      <th>Location:</th>
      <td><?php echo $patent_deposit->getLocationId() ?></td>
    </tr>
    <tr>
      <th>Environment:</th>
      <td><?php echo $patent_deposit->getEnvironmentId() ?></td>
    </tr>
    <tr>
      <th>Habitat:</th>
      <td><?php echo $patent_deposit->getHabitatId() ?></td>
    </tr>
    <tr>
      <th>Collection date:</th>
      <td><?php echo $patent_deposit->getCollectionDate() ?></td>
    </tr>
    <tr>
      <th>Isolation date:</th>
      <td><?php echo $patent_deposit->getIsolationDate() ?></td>
    </tr>
    <tr>
      <th>Identifier:</th>
      <td><?php echo $patent_deposit->getIdentifierId() ?></td>
    </tr>
    <tr>
      <th>Depositor:</th>
      <td><?php echo $patent_deposit->getDepositorId() ?></td>
    </tr>
    <tr>
      <th>Deposition date:</th>
      <td><?php echo $patent_deposit->getDepositionDate() ?></td>
    </tr>
    <tr>
      <th>Depositor code:</th>
      <td><?php echo $patent_deposit->getDepositorCode() ?></td>
    </tr>
    <tr>
      <th>Maintenance status:</th>
      <td><?php echo $patent_deposit->getMaintenanceStatusId() ?></td>
    </tr>
    <tr>
      <th>Cryopreservation method:</th>
      <td><?php echo $patent_deposit->getCryopreservationMethodId() ?></td>
    </tr>
    <tr>
      <th>Transfer interval:</th>
      <td><?php echo $patent_deposit->getTransferInterval() ?></td>
    </tr>
    <tr>
      <th>Viability test:</th>
      <td><?php echo $patent_deposit->getViabilityTest() ?></td>
    </tr>
    <tr>
      <th>Observation:</th>
      <td><?php echo $patent_deposit->getObservation() ?></td>
    </tr>
    <tr>
      <th>Citations:</th>
      <td><?php echo $patent_deposit->getCitations() ?></td>
    </tr>
    <tr>
      <th>Remarks:</th>
      <td><?php echo $patent_deposit->getRemarks() ?></td>
    </tr>
    <tr>
      <th>Bp1 link:</th>
      <td><?php echo $patent_deposit->getBp1Link() ?></td>
    </tr>
    <tr>
      <th>Bp4 link:</th>
      <td><?php echo $patent_deposit->getBp4Link() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $patent_deposit->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $patent_deposit->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('patent_deposit/edit?id='.$patent_deposit->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('patent_deposit/index') ?>">List</a>
