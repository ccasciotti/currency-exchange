<?php

namespace CurrencyExchange\Currency\Adapter;

use Zend\Json\Json;

class File extends AdapterAbstract
{
	const DATA_FILENAME = 'currency_codes.json';

	public function getDirectory()
	{
		$directory = explode(DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR, __DIR__);
		$directory = $directory[0] . DIRECTORY_SEPARATOR . 'data';

		return $directory;
	}

	public function getDataFilename()
	{
		return $this->getDirectory() . DIRECTORY_SEPARATOR . static::DATA_FILENAME;
	}

	public function getData()
	{
		$filename = $this->getDataFilename();
		if (!is_readable($filename) || $this->getForceDownload()) {
			if (!is_writable($this->getDirectory())) {
				// throw exception
			}

			$this->getDownloader()->syncData();

			$bytes = file_put_contents($filename, $this->prepareData());
			if ($bytes === false) {
				// throw exception
			}
		}

		$content = file_get_contents($filename);
		$data = Json::decode($content);

		return $data;
	}
}
