<ul>
	<?php $routes = array('extraction_kit') ?>
	<?php $subsectionNames = array( $routes[0] => 'Extraction kits') ?>
	
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