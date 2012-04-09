<ul>
	<?php $routes = array('kingdom', 'subkingdom', 'phylum', 'taxonomic_class', 'taxonomic_order', 'family', 'genus', 'species', 'authority') ?>
	<?php $subsectionNames = array(
		$routes[0] => 'Kingdoms',
		$routes[1] => 'Subkingdoms',
		$routes[2] => 'Phylums',
		$routes[3] => 'Classes',
		$routes[4] => 'Orders',
		$routes[5] => 'Families',
		$routes[6] => 'Genus',
		$routes[7] => 'Species',
		$routes[8] => 'Authorities',
	) ?>
	
	<?php foreach ( $routes as $routeValue ): ?>
		<li>
		<?php if ( preg_match('/^'.$routeValue.'_?/', $route) ): ?>
			<?php echo $subsectionNames[$routeValue] ?>
		<?php else: ?>
			<?php echo link_to($subsectionNames[$routeValue], '@'.$routeValue) ?>
		<?php endif; ?>
		</li>
		
		<?php if ( $routeValue !== $routes[count($routes)-1]): ?>
		<span class="subsection_separator">|</span>
		<?php endif; ?>
	<?php endforeach; ?>	
</ul>