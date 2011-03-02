<table>
  <tbody>
    <tr>
      <th>Name:</th>
      <td><?php echo $location->getName() ?></td>
    </tr>
    <tr>
      <th>Latitude:</th>
      <td><?php echo $location->getLatitude() ?></td>
    </tr>
    <tr>
      <th>Longitude:</th>
      <td><?php echo $location->getLongitude() ?></td>
    </tr>
    <tr>
      <th>Country:</th>
      <td><?php echo $location->getCountryId() ?></td>
    </tr>
    <tr>
      <th>Region:</th>
      <td><?php echo $location->getRegionId() ?></td>
    </tr>
    <tr>
      <th>Island:</th>
      <td><?php echo $location->getIslandId() ?></td>
    </tr>
    <tr>
      <th>Remarks:</th>
      <td><?php echo $location->getRemarks() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('location/edit?id='.$location->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('location/index') ?>">List</a>
