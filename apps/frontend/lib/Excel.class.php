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
 * @since         1.2
 * @link          https://github.com/singularfactory/ACM
 * @license       GPLv3 License (http://www.gnu.org/licenses/gpl.txt)
 */

/**
 * Export query results as CSV
 *
 * @package ACM.Frontend
 * @since 1.2
 * @version 1.2
 */
class Excel {
	/**
	 * Default field separator
	 */
	const CSV_SEPARATOR = ',';

	/**
	 * Default end of line
	 */
	const CSV_EOL = "\r\n";

	/**
	 * Header of CSV document
	 *
	 * @var string
	 */
	protected $_header = '';

	/**
	 * Data of CSV document
	 *
	 * @var string
	 */
	protected $_data = '';

	/**
	 * Set CSV document header
	 *
	 * @param array $header Array of header columns as strings
	 * @return void
	 */
	public function setHeader($headers = array()) {
		$this->_header = '';
		foreach ($headers as $column) {
			$this->_header .= sprintf('"%s"%s', trim($column), self::CSV_SEPARATOR);
		}

		$this->_header = rtrim($this->_header, self::CSV_SEPARATOR) . self::CSV_EOL;
	}

	/**
	 * Set CSV document data rows
	 *
	 * The data must be an array with N items, one item per CSV row.
	 * Every item must be an array of column values as strings.
	 *
	 * @param array $data Array with column values as string
	 * @return void
	 */
	public function setData($data = array()) {
		$this->_data = '';

		foreach ($data as $row) {
			$line = '';
			foreach ($row as $column) {
				$line .= sprintf('"%s"%s', trim($column), self::CSV_SEPARATOR);
			}
			$this->_data .= rtrim($line, self::CSV_SEPARATOR) . self::CSV_EOL;
		}
	}

	/**
	 * Generate a PHP download with the CSV document enclosed
	 *
	 * @param string $filename
	 * @return void
	 */
	public function startDownload($filename = 'results') {
		$content = $this->_header . $this->_data;

		header('Content-type: text/csv');
		header('Content-length: ' . strlen($content));
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		echo $content;
		exit();
	}
}
