<table id="samples_list">
  <thead>
    <tr>
      <th>Number</th>
      <th>Ecosystem</th>
      <th>Location</th>
      <th>Collector</th>
      <th>Date</th>
      <th>Number of strains</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($samples as $sample): ?>
    <tr>
      <td><a href="<?php echo url_for('sample/show?id='.$sample->getId()) ?>"><?php echo $sample->getNumber() ?></a></td>
      <td><a href="<?php echo url_for('sample/show?id='.$sample->getId()) ?>"><?php echo $sample->getEcosystemId() ?></a></td>
      <td><a href="<?php echo url_for('sample/show?id='.$sample->getId()) ?>"><?php echo $sample->getLocation() ?></a></td>
      <td><a href="<?php echo url_for('sample/show?id='.$sample->getId()) ?>"><?php echo $sample->getCollectorId() ?></a></td>
      <td><a href="<?php echo url_for('sample/show?id='.$sample->getId()) ?>"><?php echo $sample->getCollectionDate() ?></a></td>
      <td><a href="<?php echo url_for('sample/show?id='.$sample->getId()) ?>"><?php echo '0' ?></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('sample/new') ?>">New</a>
