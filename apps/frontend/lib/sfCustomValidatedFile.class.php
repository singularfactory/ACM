<?php
class sfCustomValidatedFile extends sfValidatedFile {

	public function save($file = null, $fileMode = 0666, $create = true, $dirMode = 0777) {
		// Let the parent class save the file and do what it normally does
		$filename = parent::save($file, $fileMode, $create, $dirMode);
		
		if ( $this->isSaved() ) {
			$path = $this->getPath();

			// Check image dimensions
			$size = getimagesize($path."/$filename");
			$dimension = $size[0]*$size[1];
			if ( $dimension >= sfConfig::get('app_max_picture_dimensions') ) {
				throw new Exception(sprintf('Image dimensions are out of limits (%s bytes)', $dimension));
			}
			else {
				// Create the thumbnail
				$thumbnail = new sfThumbnail(150, 150, true, false);
				$thumbnail->loadFile($path."/$filename");
				$thumbnail->save($path.sfConfig::get('app_thumbnails_directory').'/'.$filename, $this->getType());
			}
		}
		
		// Return the saved file as normal
		return $filename;
	}
}
