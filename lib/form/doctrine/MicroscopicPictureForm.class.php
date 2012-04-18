<?php
/**
 * Form class
 *
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
 * @package       ACM.Lib.Form
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */


/**
 * MicroscopicPicture form.
 *
 * @package ACM.Lib.Form
 * @since 1.0
 */
class MicroscopicPictureForm extends BaseMicroscopicPictureForm {
	public function configure() {
		$this->useFields(array('filename'));

		$this->setWidget('filename', new sfWidgetFormInputFileEditable(array(
			'file_src' => '',
			'edit_mode' => !$this->getObject()->isNew(),
			'is_image' => true,
			'delete_label' => 'delete',
			'template'  => '%input% <span>%delete% %delete_label%</span>',
			)));

		$this->setValidator('filename', new sfValidatorFile(array(
			'max_size' => sfConfig::get('app_max_picture_size'),
			'mime_types' => sfConfig::get('app_image_mime_types'),
			'path' => sfConfig::get('sf_upload_dir').sfConfig::get('app_sample_pictures_dir'),
			'validated_file_class' => 'sfCustomValidatedFile',
			'required' => false,
			)));

		$this->setValidator('delete_object', new sfValidatorBoolean());
	}
}
