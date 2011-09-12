<?php 

// Converts decimal degrees into degrees minutes and seconds
function convert_to_dms($coordinate) {
	$degrees = floor(abs($coordinate));
	$tmp = (abs($coordinate) - $degrees) * 60.0;
	$minutes = floor($tmp);
	$seconds = ceil(($tmp - $minutes) * 60);
	
	if ( $coordinate < 0 ) {
		$degrees = $degrees * -1;
	}
	return $degrees . 'º' . $minutes . "'" . $seconds . '"';
}
