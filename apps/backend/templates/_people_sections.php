<ul>
	<?php $routes = array('sf_guard_user', 'collector', 'isolator', 'depositor', 'identifier') ?>
	<?php $subsectionNames = array($routes[0] => 'Users', $routes[1] => 'Collectors', $routes[2] => 'Isolators', $routes[3] => 'Depositors', $routes[4] => 'Identifiers') ?>
	
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