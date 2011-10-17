<ul>
	<?php $routes = array('radiation', 'habitat', 'environment', 'purification_method') ?>
	<?php $subsectionNames = array( $routes[0] => 'Radiations', $routes[1] => 'Habitats', $routes[2] => 'Environments', $routes[3] => 'Purification methods') ?>
	
	<?php foreach ( $routes as $routeValue ): ?>
		<li>
		<?php if ( preg_match('/^'.$routeValue.'_?/', $route) || ($route == 'homepage' && $routeValue == 'radiation') ): ?>
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