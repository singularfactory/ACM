<ul>
	<?php $routes = array('maintenance_status', 'cryopreservation_method', 'container') ?>
	<?php $subsectionNames = array( $routes[0] => 'Maintenance status', $routes[1] => 'Cryopreservation methods', $routes[2] => 'Containers') ?>
	
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