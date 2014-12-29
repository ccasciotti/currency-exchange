<?php

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Currency\Adapter;

use Zend\Json\Json;
use RuntimeException;

/**
 * Concrete class to handle get and set of currency's data in file
 * 
 * @package CurrencyExchange
 */
class File extends AdapterAbstract
{
	/**
	 * Constant for currency's data filename
	 */
	const DATA_FILENAME = 'currency_codes.json';

	/**
	 * Returns the directory in which data file resides
	 * 
	 * @return string
	 */
	protected function _getDirectory()
	{
		$directory = explode(DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR, __DIR__);
		$directory = $directory[0] . DIRECTORY_SEPARATOR . 'data';

		return $directory;
	}

	/**
	 * Returns the full path of data file
	 * 
	 * @return string
	 */
	protected function _getDataFilename()
	{
		return $this->_getDirectory() . DIRECTORY_SEPARATOR . static::DATA_FILENAME;
	}

	/**
	 * Implementation of CurrencyExchange\Currency\Adapter\AdapterInterface::getData
	 * 
	 * @throws RuntimeException
	 * @return array
	 */
	public function getData()
	{
		$filename = $this->_getDataFilename();
		if (!is_readable($filename)) {
			throw new RuntimeException("Cannot get data, file $filename is not readable or doesn't exists");
		}

		$content = file_get_contents($filename);
		$data = Json::decode($content);

		return $data;
	}

	/**
	 * Implementation of CurrencyExchange\Currency\Adapter\AdapterInterface::saveData
	 * 
	 * @throws RuntimeException
	 * @return CurrencyExchange\Currency\Adapter\File
	 */
	public function saveData()
	{
		$directory = $this->_getDirectory();
		if (!is_writable($directory)) {
			throw new RuntimeException('Cannot save data, directory ' . $directory . ' is not writable');
		}

		if ($this->_downloader === null) {
			throw new RuntimeException('Cannot save data, downloader not set');
		}

		$data = $this->_downloader->makeRequest();

		$bytes = file_put_contents($this->_getDataFilename(), $data);
		if ($bytes === false) {
			throw new RuntimeException('Cannot save data, 0 bytes written');
		}

		return $this;
	}
}
