<?php
class sfCustomValidatedFile extends sfValidatedFile {

	public function save($file = null, $fileMode = 0666, $create = true, $dirMode = 0777) {
		// Let the parent class save the file and do what it normally does
		$filename = parent::save($file, $fileMode, $create, $dirMode);
		
		if ( $this->isSaved() ) {
			$path = $this->getPath();

			// Add support for alternative installation of ImageMagick binaries
			$PATH=getenv('PATH');
			putenv("PATH=$PATH:/opt/local/bin");
				
			// Create the thumbnail
			$thumbnail = new sfThumbnail(sfConfig::get('app_max_thumbnail_size'), sfConfig::get('app_max_thumbnail_size'), true, true, 75, 'sfImageMagickAdapter');
			$thumbnail->loadFile($path."/$filename");
			$thumbnail->save($path.sfConfig::get('app_thumbnails_dir').'/'.$filename, $this->getType());
		}
		
		// Return the saved file as normal
		return $filename;
	}
}