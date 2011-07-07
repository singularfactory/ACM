<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $dna_extraction->getId() ?></td>
    </tr>
    <tr>
      <th>Accession number:</th>
      <td><?php echo $dna_extraction->getAccessionNumber() ?></td>
    </tr>
    <tr>
      <th>Filename:</th>
      <td><?php echo $dna_extraction->getFilename() ?></td>
    </tr>
    <tr>
      <th>Strain:</th>
      <td><?php echo $dna_extraction->getStrainId() ?></td>
    </tr>
    <tr>
      <th>Is public:</th>
      <td><?php echo $dna_extraction->getIsPublic() ?></td>
    </tr>
    <tr>
      <th>Arrival date:</th>
      <td><?php echo $dna_extraction->getArrivalDate() ?></td>
    </tr>
    <tr>
      <th>Extraction date:</th>
      <td><?php echo $dna_extraction->getExtractionDate() ?></td>
    </tr>
    <tr>
      <th>Extraction kit:</th>
      <td><?php echo $dna_extraction->getExtractionKitId() ?></td>
    </tr>
    <tr>
      <th>Dna concentration:</th>
      <td><?php echo $dna_extraction->getDnaConcentrationId() ?></td>
    </tr>
    <tr>
      <th>Aliquots:</th>
      <td><?php echo $dna_extraction->getAliquots() ?></td>
    </tr>
    <tr>
      <th>Remarks:</th>
      <td><?php echo $dna_extraction->getRemarks() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $dna_extraction->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $dna_extraction->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('dna_extraction/edit?id='.$dna_extraction->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('dna_extraction/index') ?>">List</a>
