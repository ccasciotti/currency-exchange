<?php

namespace CurrencyExchange\Currency\Adapter;

use CurrencyExchange\Currency\Downloader;
use Zend\Json\Json;

abstract class AdapterAbstract implements AdapterInterface
{
	protected $_downloader = null;
	protected $_forceDownload = null;

	public function __construct()
	{
		$this->_downloader = new Downloader();
	}
	
	public function getDownloader()
	{
		return $this->_downloader;
	}
	
	public function getForceDownload()
	{
		return $this->_forceDownload;
	}

	public function setForceDownload($forceDownload = true)
	{
		$this->_forceDownload = (bool) $forceDownload;
		return $this;
	}
	
	public function prepareData()
	{
		$data = Json::decode($this->_downloader->getData());

		$preparedData = array_filter($data, function($element) {
			return !isset($element->WithdrawalDate);
		});

		return Json::encode($preparedData);
	}
}
