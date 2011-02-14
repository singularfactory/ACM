<h1>Ecosystems List</h1>

<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>City</th>
      <th>Province</th>
      <th>Lanscape picture</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($ecosystems as $ecosystem): ?>
    <tr>
      <td><a href="<?php echo url_for('ecosystem/edit?id='.$ecosystem->getId()) ?>"><?php echo $ecosystem->getName() ?></a></td>
      <td><a href="<?php echo url_for('ecosystem/edit?id='.$ecosystem->getId()) ?>"><?php echo $ecosystem->getCity() ?></a></td>
      <td><a href="<?php echo url_for('ecosystem/edit?id='.$ecosystem->getId()) ?>"><?php echo $ecosystem->getProvinceId() ?></a></td>
      <td><a href="<?php echo url_for('ecosystem/edit?id='.$ecosystem->getId()) ?>"><?php echo $ecosystem->getLanscapePicture() ?></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('ecosystem/new') ?>">New</a>
