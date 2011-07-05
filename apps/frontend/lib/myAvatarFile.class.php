<?php
class myAvatarFile extends sfValidatedFile {

	public function save($file = null, $fileMode = 0660, $create = true, $dirMode = 0770) {
		// Let the parent class temporarily save the file and do what it normally does
		$filename = parent::save($file, $fileMode, $create, $dirMode);
		
		if ( $this->isSaved() ) {				
			// Add support for alternative installation of ImageMagick binaries
			$PATH=getenv('PATH');
			putenv("PATH=$PATH:/opt/local/bin");

			// Resize the avatar
			$path = $this->getPath();
			$avatar = new sfThumbnail(sfConfig::get('app_max_avatar_size'), sfConfig::get('app_max_avatar_size'), true, true, 300, 'sfImageMagickAdapter');
			$avatar->loadFile("$path/$filename");
			$avatar->save("$path/$filename", $this->getType());
		}
		
		// Return the saved file as normal
		return $filename;
	}
}
