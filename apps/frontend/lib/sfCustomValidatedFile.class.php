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
class sfCustomValidatedFile extends sfValidatedFile {
	public function save($file = null, $fileMode = 0660, $create = true, $dirMode = 0770) {
		// Let the parent class save the file and do what it normally does
		$filename = parent::save($file, $fileMode, $create, $dirMode);

		// Create the thumbnail if the file was successfully saved
		$pngPictureFilename = $filename;
		if ($this->isSaved()) {
			// Add support for alternative installation of ImageMagick binaries
			$PATH=getenv('PATH');
			putenv("PATH=$PATH:/opt/local/bin");

			// Create thumbnails directory if not exists
			$path = $this->getPath();
			$thumbnailsDirectory = $path.sfConfig::get('app_thumbnails_dir');
			if (!is_dir($thumbnailsDirectory)) {
				mkdir($thumbnailsDirectory, 0770);
			}

			// Create the thumbnail by resizing the image
			$thumbnail = new sfThumbnail(sfConfig::get('app_max_thumbnail_size'), sfConfig::get('app_max_thumbnail_size'), true, true, 300, 'sfImageMagickAdapter');
			$thumbnail->loadFile("$path/$filename");
			$thumbnailFilename = preg_replace('/\.[\w\-]+$/', sfConfig::get('app_thumbnail_extension'), $filename);
			$thumbnail->save("$thumbnailsDirectory/$thumbnailFilename", 'image/png');

			// Create a PNG version of the picture
			$pngPicture = new sfThumbnail(null, null, true, true, sfConfig::get('app_picture_resolution'), 'sfImageMagickAdapter');
			$pngPicture->loadFile("$path/$filename");
			$pngPictureFilename = preg_replace('/\.[\w\-]+$/', sfConfig::get('app_picture_extension'), $filename);
			$pngPicture->save("$path/$pngPictureFilename");

			// Delete the uploaded file
			$extensionRegexp = sprintf('/%s$/', sfConfig::get('app_picture_extension'));
			if (!preg_match($extensionRegexp, $filename)) {
				unlink("$path/$filename");
			}
		}

		// Return the saved file as normal
		return $pngPictureFilename;
	}
}
