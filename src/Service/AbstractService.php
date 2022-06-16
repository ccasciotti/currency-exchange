<?php

declare(strict_types=1);

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/ccasciotti/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Service;

use CurrencyExchange\Exception\ResponseException;
use CurrencyExchange\Http\Client as HttpClient;
use CurrencyExchange\Uri\AbstractUri;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;

/**
 * Abstract class for each exchange service
 * 
 * @package CurrencyExchange
 * @abstract
 */
abstract class AbstractService implements ServiceInterface
{
	/**
	 * @var AbstractUri|null
     */
	protected ?AbstractUri $uri = null;

	/**
	 * @var HttpClient|null
     */
	protected ?HttpClient $httpClient = null;

    /**
     * Instantiates a new HttpClient object and initializes it with http type of uri
     *
     * @param AbstractUri $uri
     */
	public function __construct(AbstractUri $uri)
	{
		$this->setUri($uri);

		/** @var HttpClient */
		$httpClient = new HttpClient();
        $httpClient->getHttpRequest()?->setHttpMethod($this->getUri()->getType());

		$this->setHttpClient($httpClient);
	}

	/**
	 * Returns uri object
	 * 
	 * @return AbstractUri
	 */
	public function getUri(): AbstractUri
    {
		return $this->uri;
	}

    /**
     * Returns http client object
     *
     * @return HttpClient|null
     */
	public function getHttpClient(): ?HttpClient
    {
		return $this->httpClient;
	}

	/**
	 * Set a new uri object to handle exchange service
	 * 
	 * @param AbstractUri $uri
	 * @return AbstractService
	 */
	public function setUri(AbstractUri $uri): static
    {
		$this->uri = $uri;
		return $this;
	}

	/**
	 * Set a new http client object to handle exchange method's request and response
	 * 
	 * @param HttpClient $client
	 * @return AbstractService
	 */
	public function setHttpClient(HttpClient $client): static
    {
		$this->httpClient = $client;
		return $this;
	}

    /**
     * Make request via HttpClient object and returns response
     *
     * @return Response|null
     * @throws ResponseException
     * @throws GuzzleException
     */
    public function getResponseContent(): ?Response
    {
        return $this
            ->getHttpClient()
            ?->setUri($this->getUri()->getFinalUri())
            ->makeRequest()
            ->getResponse()
        ;
    }
}