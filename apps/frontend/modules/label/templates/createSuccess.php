<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
	<head> 
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
		<meta name="title" content="Algae culture management | Banco Español de Algas" /> 
		<meta name="description" content="Algae culture management of Banco Español de Algas" /> 
		<meta name="keywords" content="algae, bna, bea, banco, nacional, algas, español, marine, biotechnology, strains, culture" /> 
		<meta name="language" content="en" /> 
		<meta name="robots" content="index, follow" /> 
		<title>Algae culture management | Banco Español de Algas</title> 
		<link rel="shortcut icon" href="/favicon.ico" /> 
		<link rel="stylesheet" type="text/css" media="screen" href="/css/labels.css" /> 
	</head> 
	<body> 
		<table id="labels_list">
			<tbody>
				<?php if ( $allProducts ): ?>
					<?php foreach ($labels as $label): ?>
						<tr>
							<td class="label_item"><?php echo $label ?></td>
						</tr>
					<?php endforeach ?>
				<?php else: ?>
					<?php for ( $i=0; $i < $maxRows; $i++ ): ?>
						<tr class="label_items">
							<?php for ( $j=0; $j < $maxColumns; $j++ ): ?>
								<td class="label_item">
									<p class="label_item_code"><?php echo $labels->getCode() ?></p>
									<p class="label_item_genus"><?php echo $labels->getGenus() ?></p>
									<p class="label_item_species"><?php echo $labels->getSpecies() ?></p>
									<p class="label_item_taxonomic_class"><?php echo $labels->getTaxonomicClass() ?></p>
									<p class="label_item_culture_medium"><?php echo $cultureMedium ?></p>
									<p class="label_item_transfer_interval"><?php echo $supervisor.substr($labels->getTaxonomicClass(), 0, 3).$transferInterval ?></p>
								</td>
							<?php endfor ?>
						</tr>
					<?php endfor ?>
				<?php endif ?>
				
				
			</tbody>
		</table>		
	</body> 
</html>
