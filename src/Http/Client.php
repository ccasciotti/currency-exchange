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

namespace CurrencyExchange\Http;

use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use CurrencyExchange\Exception\ResponseException;
use CurrencyExchange\Http\Request as HttpRequest;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response;

/**
 * Makes a request to the current Uri
 * 
 * @package CurrencyExchange
 */
class Client
{
	/**
	 * @var string|null
	 */
	protected ?string $uri = null;

	/**
	 * @var HttpRequest|null
     */
	protected ?Request $httpRequest = null;

	/**
	 * @var array The data to send via Http POST 
	 */
	protected array $postData = [];

	/**
	 * @var Response|null
     */
	protected ?Response $response = null;

	/**
	 * Constructor set Options object
	 */
	public function __construct()
	{
		$this->httpRequest = new Request();
	}

    /**
     * @return Response|null
     */
	public function getResponse(): ?Response
    {
		return $this->response;
	}

	/**
	 * Set Http response in case of successful request
	 * 
	 * @param Response $response
	 * @return $this
     * @throws ResponseException
	 */
	public function setResponse(Response $response): static
    {
        if ($response->getStatusCode() !== 200) {
			throw new ResponseException(
                sprintf(
                    'Unsuccessful HTTP request: %d on %s',
                    $response->getStatusCode(),
                    $this->getUri()
                )
            );
		}

        $this->response = $response;
		return $this;
	}

    /**
     * @return Request|null
     */
	public function getHttpRequest(): ?Request
    {
		return $this->httpRequest;
	}

	/**
	 * @return array
	 */
	public function getPostData(): array
    {
		return $this->postData;
	}

    /**
     * Return current uri
     *
     * @return string|null
     */
    public function getUri(): ?string
    {
        return $this->uri;
    }

    /**
	 * @param string $uri
	 * @return $this
	 */
	public function setUri(string $uri): static
    {
		$this->uri = $uri;
		return $this;
	}

	/**
	 * Set data to be sent via Http POST
	 * 
	 * @param array $postData
	 * @return $this
	 */
	public function setPostData(array $postData): static
    {
		$this->postData = $postData;
		return $this;
	}

	/**
	 * Set proxy for the http client
	 * 
	 * @param string $proxy A string that identifies proxy server, in the format 'host:port'
	 * @return $this
     * @throws InvalidArgumentException
	 */
	public function setProxy(string $proxy): static
    {
		if (!preg_match('/^[a-z\d\.]+:\d+$/iu', $proxy)) {
			throw new InvalidArgumentException('Proxy must be a string according to format host:port');
		}

		$this->getHttpRequest()->getOptions()->add('proxy', $proxy);
		return $this;
	}

    /**
     * Makes request to the uri currently set
     *
     * @return $this
     * @throws ResponseException
     * @throws GuzzleException
     */
	public function makeRequest(): static
    {
        $requestOptions = $this->getHttpRequest()?->getOptions()->getAll() ?: [];

        $client = new GuzzleClient([
            'headers' => $this->getHttpRequest()?->getHeaders()->getAll()
        ]);
        $response = $client->request($this->getHttpRequest()->getHttpMethod(), $this->getUri(), $requestOptions);

		// setting response
		$this->setResponse($response);
		return $this;
	}
}
