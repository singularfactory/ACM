<h1>Dna extractions List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Accession number</th>
      <th>Filename</th>
      <th>Strain</th>
      <th>Is public</th>
      <th>Arrival date</th>
      <th>Extraction date</th>
      <th>Extraction kit</th>
      <th>Dna concentration</th>
      <th>Aliquots</th>
      <th>Remarks</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($dna_extractions as $dna_extraction): ?>
    <tr>
      <td><a href="<?php echo url_for('dna_extraction/show?id='.$dna_extraction->getId()) ?>"><?php echo $dna_extraction->getId() ?></a></td>
      <td><?php echo $dna_extraction->getAccessionNumber() ?></td>
      <td><?php echo $dna_extraction->getFilename() ?></td>
      <td><?php echo $dna_extraction->getStrainId() ?></td>
      <td><?php echo $dna_extraction->getIsPublic() ?></td>
      <td><?php echo $dna_extraction->getArrivalDate() ?></td>
      <td><?php echo $dna_extraction->getExtractionDate() ?></td>
      <td><?php echo $dna_extraction->getExtractionKitId() ?></td>
      <td><?php echo $dna_extraction->getDnaConcentrationId() ?></td>
      <td><?php echo $dna_extraction->getAliquots() ?></td>
      <td><?php echo $dna_extraction->getRemarks() ?></td>
      <td><?php echo $dna_extraction->getCreatedAt() ?></td>
      <td><?php echo $dna_extraction->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('dna_extraction/new') ?>">New</a>
