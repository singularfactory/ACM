<?php

function get_thumbnail($filename, $module) {
  $filename = sfConfig::get('app_pictures_dir').sfConfig::get("app_{$module}_pictures_dir").sfConfig::get('app_thumbnails_dir').'/'.$filename;
	return preg_replace('/\.[\-\w]+$/', sfConfig::get('app_thumbnail_extension'), $filename);
}

function get_picture_with_path($filename, $module) {
	return sfConfig::get('app_pictures_dir').sfConfig::get("app_{$module}_pictures_dir").'/'.$filename;
}