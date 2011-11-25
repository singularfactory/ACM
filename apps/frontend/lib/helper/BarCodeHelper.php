<?php

function getBarCode($content) {
	$url = sfConfig::get('app_root_url').url_for("@api_generate_barcode?code=$content");
	return image_tag($url, array('alt' => $content, 'width' => 150, 'height' => 30));
}
