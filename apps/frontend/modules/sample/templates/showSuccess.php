<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $sample->getId() ?></td>
    </tr>
    <tr>
      <th>Number:</th>
      <td><?php echo $sample->getNumber() ?></td>
    </tr>
    <tr>
      <th>Ecosystem:</th>
      <td><?php echo $sample->getEcosystemId() ?></td>
    </tr>
    <tr>
      <th>Location:</th>
      <td><?php echo $sample->getLocation() ?></td>
    </tr>
    <tr>
      <th>Latitude degrees:</th>
      <td><?php echo $sample->getLatitudeDegrees() ?></td>
    </tr>
    <tr>
      <th>Longitude degrees:</th>
      <td><?php echo $sample->getLongitudeDegrees() ?></td>
    </tr>
    <tr>
      <th>Latitude minutes:</th>
      <td><?php echo $sample->getLatitudeMinutes() ?></td>
    </tr>
    <tr>
      <th>Longitude minutes:</th>
      <td><?php echo $sample->getLongitudeMinutes() ?></td>
    </tr>
    <tr>
      <th>Environment:</th>
      <td><?php echo $sample->getEnvironmentId() ?></td>
    </tr>
    <tr>
      <th>Habitat:</th>
      <td><?php echo $sample->getHabitatId() ?></td>
    </tr>
    <tr>
      <th>Ph:</th>
      <td><?php echo $sample->getPh() ?></td>
    </tr>
    <tr>
      <th>Conductivity:</th>
      <td><?php echo $sample->getConductivity() ?></td>
    </tr>
    <tr>
      <th>Temperature:</th>
      <td><?php echo $sample->getTemperature() ?></td>
    </tr>
    <tr>
      <th>Salinity:</th>
      <td><?php echo $sample->getSalinity() ?></td>
    </tr>
    <tr>
      <th>Close picture:</th>
      <td><?php echo $sample->getClosePicture() ?></td>
    </tr>
    <tr>
      <th>Laboratory picture:</th>
      <td><?php echo $sample->getLaboratoryPicture() ?></td>
    </tr>
    <tr>
      <th>Collector:</th>
      <td><?php echo $sample->getCollectorId() ?></td>
    </tr>
    <tr>
      <th>Collection date:</th>
      <td><?php echo $sample->getCollectionDate() ?></td>
    </tr>
    <tr>
      <th>Remarks:</th>
      <td><?php echo $sample->getRemarks() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $sample->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $sample->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('sample/edit?id='.$sample->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('sample/index') ?>">List</a>
