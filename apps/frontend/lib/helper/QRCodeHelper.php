<?php
/**
 * acm : Algae Culture Management (https://github.com/singularfactory/ACM)
 * Copyright 2012, Singular Factory <info@singularfactory.com>
 *
 * This file is part of ACM
 *
 * ACM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ACM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ACM.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright     Copyright 2012, Singular Factory <info@singularfactory.com>
 * @package       ACM.Frontend
 * @since         1.0
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */
?>
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
