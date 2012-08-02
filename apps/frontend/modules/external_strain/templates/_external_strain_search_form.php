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
 * @since         1.2
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */
?>
<div id="id">
	<?php echo $form['id']->renderLabel() ?>
	<?php echo $form['id'] ?>
</div>
<div id="taxonomic_class">
	<?php echo $form['taxonomic_class_id']->renderLabel() ?>
	<?php echo $form['taxonomic_class_id'] ?>
</div>
<div id="genus">
	<?php echo $form['genus_id']->renderLabel() ?>
	<?php echo $form['genus_id'] ?>
</div>
<div id="species">
	<?php echo $form['species_id']->renderLabel() ?>
	<?php echo $form['species_id'] ?>
</div>
<div id="authority">
	<?php echo $form['authority_id']->renderLabel() ?>
	<?php echo $form['authority_id'] ?>
</div>
<div id="maintenance_status">
	<?php echo $form['maintenance_status_id']->renderLabel() ?>
	<?php echo $form['maintenance_status_id'] ?>
</div>
<div id="culture_medium">
	<?php echo $form['culture_medium_id']->renderLabel() ?>
	<?php echo $form['culture_medium_id'] ?>
</div>
<div id="transfer_interval">
	<?php echo $form['transfer_interval']->renderLabel() ?>
	<?php echo $form['transfer_interval'] ?>
</div>
<div id="epitype">
	<?php echo $form['is_epitype']->renderLabel() ?>
	<?php echo $form['is_epitype'] ?>
</div>
<div id="axenic">
	<?php echo $form['is_axenic']->renderLabel() ?>
	<?php echo $form['is_axenic'] ?>
</div>
<div id="group_by">
	<?php echo $form['group_by']->renderLabel() ?>
	<?php echo $form['group_by'] ?>
</div>
