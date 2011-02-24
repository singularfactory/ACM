<?php slot('content_title', 'All environments') ?>

<table>
  <thead>
    <tr>
      <th>Name</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($environments as $environment): ?>
    <tr>
      <td><a href="<?php echo url_for('environment/edit?id='.$environment->getId()) ?>"><?php echo $environment->getName() ?></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<a href="<?php echo url_for('environment/new') ?>">Add a new environment</a>
