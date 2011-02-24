<?php slot('content_title', 'All countries and regions') ?>

<table id="countries_list">
  <thead>
    <tr>
      <th>Name</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($countrys as $country): ?>
    <tr>
      <td><a href="<?php echo url_for('country/edit?id='.$country->getId()) ?>"><?php echo $country->getName() ?></a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<a href="<?php echo url_for('country/new') ?>">Add a new country or region</a>
