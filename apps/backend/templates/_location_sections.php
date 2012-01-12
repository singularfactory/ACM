<ul>
	<?php $routes = array('country', 'region', 'island', 'location_category') ?>
	<?php $subsectionNames = array( $routes[0] => 'Countries', $routes[1] => 'Regions', $routes[2] => 'Islands', $routes[3] => 'Categories') ?>
	
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