<?php
class sfCustomValidatedFile extends sfValidatedFile {

	public function save($file = null, $fileMode = 0660, $create = true, $dirMode = 0770) {
		// Let the parent class save the file and do what it normally does
		$filename = parent::save($file, $fileMode, $create, $dirMode);
		
		// Create the thumnbail if the file was successfully saved
		if ( $this->isSaved() ) {
			// Add support for alternative installation of ImageMagick binaries
			$PATH=getenv('PATH');
			putenv("PATH=$PATH:/opt/local/bin");
			
			// Create thumbnails directory if not exists
			$path = $this->getPath();
			$thumbnailsDirectory = $path.sfConfig::get('app_thumbnails_dir');
			if ( !is_dir($thumbnailsDirectory) ) {
				mkdir($thumbnailsDirectory, 0770);
			}
				
			// Create the thumbnail by resizing the image
			$thumbnail = new sfThumbnail(sfConfig::get('app_max_thumbnail_size'), sfConfig::get('app_max_thumbnail_size'), true, true, 300, 'sfImageMagickAdapter');
			$thumbnail->loadFile("$path/$filename");
			$thumbnailFilename = preg_replace('/\.[\w\-]+$/', sfConfig::get('app_thumbnail_extension'), $filename);
			$thumbnail->save("$thumbnailsDirectory/$thumbnailFilename", 'image/png');
		}
		
		// Return the saved file as normal
		return $filename;
	}
}
