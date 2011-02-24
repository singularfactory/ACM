<?php slot('content_title', 'All provinces and islands') ?>

<table id="provinces_list">
  <thead>
    <tr>
      <th>Name</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($provinces as $province): ?>
    <tr>
      <td><a href="<?php echo url_for('province/edit?id='.$province->getId()) ?>"><?php echo $province->getName() ?></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<a href="<?php echo url_for('province/new') ?>">Add a new province or island</a>
