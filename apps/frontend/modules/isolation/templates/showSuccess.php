<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $isolation->getId() ?></td>
    </tr>
    <tr>
      <th>Reception date:</th>
      <td><?php echo $isolation->getReceptionDate() ?></td>
    </tr>
    <tr>
      <th>Isolation subject:</th>
      <td><?php echo $isolation->getIsolationSubject() ?></td>
    </tr>
    <tr>
      <th>Sample:</th>
      <td><?php echo $isolation->getSampleId() ?></td>
    </tr>
    <tr>
      <th>Strain:</th>
      <td><?php echo $isolation->getStrainId() ?></td>
    </tr>
    <tr>
      <th>External code:</th>
      <td><?php echo $isolation->getExternalCode() ?></td>
    </tr>
    <tr>
      <th>Taxonomic class:</th>
      <td><?php echo $isolation->getTaxonomicClassId() ?></td>
    </tr>
    <tr>
      <th>Genus:</th>
      <td><?php echo $isolation->getGenusId() ?></td>
    </tr>
    <tr>
      <th>Species:</th>
      <td><?php echo $isolation->getSpeciesId() ?></td>
    </tr>
    <tr>
      <th>Authority:</th>
      <td><?php echo $isolation->getAuthorityId() ?></td>
    </tr>
    <tr>
      <th>Location:</th>
      <td><?php echo $isolation->getLocationId() ?></td>
    </tr>
    <tr>
      <th>Environment:</th>
      <td><?php echo $isolation->getEnvironmentId() ?></td>
    </tr>
    <tr>
      <th>Habitat:</th>
      <td><?php echo $isolation->getHabitatId() ?></td>
    </tr>
    <tr>
      <th>Delivery date:</th>
      <td><?php echo $isolation->getDeliveryDate() ?></td>
    </tr>
    <tr>
      <th>Purification method:</th>
      <td><?php echo $isolation->getPurificationMethodId() ?></td>
    </tr>
    <tr>
      <th>Purification details:</th>
      <td><?php echo $isolation->getPurificationDetails() ?></td>
    </tr>
    <tr>
      <th>Observation:</th>
      <td><?php echo $isolation->getObservation() ?></td>
    </tr>
    <tr>
      <th>Remarks:</th>
      <td><?php echo $isolation->getRemarks() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $isolation->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $isolation->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('isolation/edit?id='.$isolation->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('isolation/index') ?>">List</a>
