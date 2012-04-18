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
<?php
class myAvatarFile extends sfValidatedFile {

	public function save($file = null, $fileMode = 0660, $create = true, $dirMode = 0770) {
		// Let the parent class temporarily save the file and do what it normally does
		$filename = parent::save($file, $fileMode, $create, $dirMode);

		// Create the avatar if the file was saved
		$avatarFilename = $filename;
		if ( $this->isSaved() ) {
			// Add support for alternative installation of ImageMagick binaries
			$PATH=getenv('PATH');
			putenv("PATH=$PATH:/opt/local/bin");

			// Resize the avatar
			$path = $this->getPath();
			$avatar = new sfThumbnail(sfConfig::get('app_max_avatar_size'), sfConfig::get('app_max_avatar_size'), true, true, 300, 'sfImageMagickAdapter');
			$avatar->loadFile("$path/$filename");

			// Save the avatar as a PNG file
			$avatarFilename = preg_replace('/\.[\w\-]+$/', sfConfig::get('app_thumbnail_extension'), $filename);
			$avatar->save("$path/$avatarFilename", 'image/png');

			// Delete the uploaded file
			if ( !preg_match('/\.png$/', $filename) ) {
				unlink("$path/$filename");
			}
		}

		// Return the saved file as normal
		return $avatarFilename;
	}
}
