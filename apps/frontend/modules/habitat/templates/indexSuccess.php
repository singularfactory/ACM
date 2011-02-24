<?php slot('content_title', 'All habitats') ?>

<table>
  <thead>
    <tr>
      <th>Name</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($habitats as $habitat): ?>
    <tr>
      <td><a href="<?php echo url_for('habitat/edit?id='.$habitat->getId()) ?>"><?php echo $habitat->getName() ?></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('habitat/new') ?>">Add a new habitat</a>
