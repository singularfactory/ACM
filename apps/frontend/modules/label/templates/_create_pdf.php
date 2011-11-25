<?php use_helper('BarCode'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="title" content="Algae culture management | Banco Español de Algas" />
		<meta name="description" content="Algae culture management of Banco Español de Algas" />
		<meta name="keywords" content="bea, banco, español, algas, marine, biotechnology, spanish, banl, algae" />
		<meta name="language" content="en" />
		<meta name="robots" content="index, follow" />
		<title>Algae culture management | Banco Español de Algas</title>
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="stylesheet" type="text/css" media="screen" href="/css/labels.css" />
	</head> 
	<body>
		<table>
			<tbody>
				<?php $columns = 0 ?>
				<?php if ( $allProducts ): // Every label is a different product ?>
					<?php foreach ( $labels as $label ): ?>

						<?php if ( $columns == 0 ): ?><tr class="label_items"><?php endif ?>
						<td class="label_item">
							<?php echo getBarCode($label->getFullCode()) ?>
							<p class="label_item_code"><?php echo $label->getFullCode() ?></p>

							<p class="label_item_genus"><?php echo $label->getGenus() ?></p>

							<p class="label_item_species"><?php echo $label->getSpecies() ?></p>

							<p class="label_item_taxonomic_class"><?php echo $label->getTaxonomicClass() ?></p>

							<p class="label_item_culture_medium"><?php echo $cultureMedium ?></p>

							<p class="label_item_transfer_interval"><?php echo $supervisor.substr($label->getTaxonomicClass(), 0, 3).$transferInterval ?></p>
						</td>
						<?php $columns++ ?>

						<?php if ( $columns == 4): ?></tr><?php $columns = 0 ?><?php endif ?>

					<?php endforeach ?>
				<?php else: ?>
					<?php $label = $labels ?>
					<?php $qrImage = getBarCode($label->getFullCode()) ?>
					<?php for ( $i = 0; $i < 12; $i++ ): ?>

						<?php if ( $columns == 0 ): ?><tr class="label_items"><?php endif ?>
						<td class="label_item">
							<?php echo $qrImage ?>
							<p class="label_item_code"><?php echo $label->getFullCode() ?></p>
							<p class="label_item_genus"><?php echo $label->getGenus() ?></p>
							<p class="label_item_species"><?php echo $label->getSpecies() ?></p>
							<p class="label_item_taxonomic_class"><?php echo $label->getTaxonomicClass() ?></p>
							<p class="label_item_culture_medium"><?php echo $cultureMedium ?></p>
							<p class="label_item_transfer_interval"><?php echo $supervisor.substr($label->getTaxonomicClass(), 0, 3).$transferInterval ?></p>
						</td>
						<?php $columns++ ?>

						<?php if ( $columns == 4): ?></tr><?php $columns = 0 ?><?php endif ?>

					<?php endfor ?>
				<?php endif ?>
			</tbody>
		</table>		
		
	</body> 
</html>
