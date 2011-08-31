<?php
class myDocument extends sfValidatedFile {

	public function generateFilename() {
		$filename = preg_replace('/\..{2,4}$/', '$1', $this->getOriginalName()).'_'.time();
		return $filename.$this->getExtension($this->getOriginalExtension());
	}
	
}
