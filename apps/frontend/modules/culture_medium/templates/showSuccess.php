<?php
/**
 * acm : Algae Culture Management (https://github.com/singularfactory/ACM)
 * Copyright 2012, Singular Factory <info@singularfactory.com>
 *
 * This file is part of ACM
 *
 * ACM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ACM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ACM.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright     Copyright 2012, Singular Factory <info@singularfactory.com>
 * @package       ACM.Frontend
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */
?>
<?php slot('main_header') ?>
<span>
	<?php echo $cultureMedium->getCode() ?>
</span>
<?php include_partial('global/back_header_action', array('module' => 'culture_medium')) ?>
<?php include_partial('global/edit_header_action', array('module' => 'culture_medium', 'id' => $cultureMedium->getId())) ?>
<?php include_partial('global/delete_header_action', array('module' => 'culture_medium', 'id' => $cultureMedium->getId())) ?>
<?php end_slot() ?>

<div id="main_view_show">
	<div id="object_data_list">
		<dl>
			<dt>Code:</dt>
			<dd><?php echo $cultureMedium->getCode() ?></dd>
			<dt>Name:</dt>
			<dd><?php echo $cultureMedium->getName() ?></dd>
			<dt>Link:</dt>
			<dd><?php echo link_to($cultureMedium->getLink(), $cultureMedium->getLink(), array('popup' => true)) ?></dd>
			<dt>Description:</dt>
			<dd>
				<?php if ( $url = $cultureMedium->getDescriptionUrl() ): ?>
				<?php echo link_to($cultureMedium->getDescription(), $url) ?>
				<?php else: ?>
				<?php echo sfConfig::get('app_no_data_message') ?>
				<?php endif; ?>
			</dd>
			<dt>Is public:</dt>
			<dd><?php echo $cultureMedium->getFormattedIsPublic() ?></dd>
			<dt>Strains:</dt>
			<dd>
				<?php echo $nbStrains = $cultureMedium->getNbStrains() ?>
				<?php if ( $nbStrains > 0 ): ?>
					<a href="#culture_medium_strains_list" title="List of strains who used this culture medium" class="page_jump">see below</a>
				<?php endif; ?>
			</dd>
		</dl>
	</div>

	<?php if ( $nbStrains > 0): ?>
	<div id="culture_medium_strains_list" class="object_related_model_long_list">
		<h2>Strains</h2>
		<table>
			<tr>
				<th class="code">Code</th>
				<th>Class:</th>
				<th>Genus:</th>
				<th>Species:</th>
			</tr>
			<?php foreach ($cultureMedium->getStrains() as $strain ): ?>
			<?php $url = '@strain_show?id='.$strain->getId() ?>
			<tr>
				<td><?php echo link_to($strain->getFullCode(), $url) ?></td>
				<td><?php echo link_to($strain->getTaxonomicClass(), $url) ?></td>
				<td><span class="species_name"><?php echo link_to($strain->getGenus(), $url) ?></span></td>
				<td><span class="species_name"><?php echo link_to($strain->getSpecies(), $url) ?></span></td>
			</tr>
		<?php endforeach ?>
		</table>
	</div>
	<?php endif ?>

	<div class="clear"></div>
</div>
