<?php

define('QR_GOOGLE_API_URL', 'http://chart.apis.google.com/chart');

function getQR($content, $size =50, $level = 'L', $margin = 0) {
	$parameters = array(
		'chs=' . sprintf('%dx%d', $size, $size),
		'cht=' . 'qr',
		'chld=' . sprintf('%s|%d', $level, $margin),
		'chl=' . urlencode($content),
	);
	
	$url = sprintf('%s?%s', QR_GOOGLE_API_URL, implode('&', $parameters));
	return image_tag($url, array('alt' => $content, 'width' => $size, 'height' => $size));
}
