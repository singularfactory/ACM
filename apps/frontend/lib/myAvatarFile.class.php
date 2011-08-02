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
			$avatarFilename = preg_replace('/\.[\w\-]+$/', '.png', $filename);
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
