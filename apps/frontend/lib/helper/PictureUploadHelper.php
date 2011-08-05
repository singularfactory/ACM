<?php

function get_uid() {
	return md5(uniqid(mt_rand(), true));
}

function progress_key() {
	return tag('input', array('type' => 'hidden', 'value' => get_uid(), 'id' => 'progress_key', 'name' => 'APC_UPLOAD_PROGRESS'));
}

function progress_bar() {
	return '<div id="progressbar_wrapper"><p>Uploading files...</p><div id="progressbar"></div></div>';
}