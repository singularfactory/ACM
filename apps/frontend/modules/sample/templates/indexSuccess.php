<h1>Samples List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Number</th>
      <th>Ecosystem</th>
      <th>Location</th>
      <th>Latitude degrees</th>
      <th>Longitude degrees</th>
      <th>Latitude minutes</th>
      <th>Longitude minutes</th>
      <th>Environment</th>
      <th>Habitat</th>
      <th>Ph</th>
      <th>Conductivity</th>
      <th>Temperature</th>
      <th>Salinity</th>
      <th>Close picture</th>
      <th>Laboratory picture</th>
      <th>Collector</th>
      <th>Collection date</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($samples as $sample): ?>
    <tr>
      <td><a href="<?php echo url_for('sample/show?id='.$sample->getId()) ?>"><?php echo $sample->getId() ?></a></td>
      <td><?php echo $sample->getNumber() ?></td>
      <td><?php echo $sample->getEcosystemId() ?></td>
      <td><?php echo $sample->getLocation() ?></td>
      <td><?php echo $sample->getLatitudeDegrees() ?></td>
      <td><?php echo $sample->getLongitudeDegrees() ?></td>
      <td><?php echo $sample->getLatitudeMinutes() ?></td>
      <td><?php echo $sample->getLongitudeMinutes() ?></td>
      <td><?php echo $sample->getEnvironmentId() ?></td>
      <td><?php echo $sample->getHabitatId() ?></td>
      <td><?php echo $sample->getPh() ?></td>
      <td><?php echo $sample->getConductivity() ?></td>
      <td><?php echo $sample->getTemperature() ?></td>
      <td><?php echo $sample->getSalinity() ?></td>
      <td><?php echo $sample->getClosePicture() ?></td>
      <td><?php echo $sample->getLaboratoryPicture() ?></td>
      <td><?php echo $sample->getCollectorId() ?></td>
      <td><?php echo $sample->getCollectionDate() ?></td>
      <td><?php echo $sample->getCreatedAt() ?></td>
      <td><?php echo $sample->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('sample/new') ?>">New</a>
