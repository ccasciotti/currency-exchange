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

use CurrencyExchange\Options\Options;
use InvalidArgumentException;
use RuntimeException;

/**
 * Handles the Http request options
 * 
 * @package CurrencyExchange
 */
class Request
{
    /**
	 * Constant for HTTP method GET
	 */
	public const HTTP_GET = 'GET';

	/**
	 * Constant for HTTP method POST
	 */
	public const HTTP_POST = 'POST';

    /**
     * Constant for Defaut User Agent
     */
    public const DEFAULT_USER_AGENT = 'Currency Exchange';

    /**
     * @var string
     */
    protected string $httpMethod;

    /**
     * @var Options
     */
    protected Options $httpHeaders;

    /**
     * @var Options
     */
    protected Options $options;

    /**
     * Constructor initialize Options object with standard options
     */
    public function __construct()
    {
        $this->httpMethod = static::HTTP_GET;

        $this->httpHeaders = new Options();
        $this->httpHeaders->setOptions([
           'User-Agent' => static::DEFAULT_USER_AGENT,
        ]);

        $this->options = new Options();
    }

    /**
     * Return current http method
     * 
     * @return string
     */
    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * Returns Options object
     * 
     * @return Options
     */
    public function getOptions(): Options
    {
        return $this->options;
    }

    /**
     * Returns Options object
     * 
     * @return Options
     */
    public function getHeaders(): Options
    {
        return $this->httpHeaders;
    }

    /**
	 * Checks if Http method is GET
	 * 
	 * @return boolean
	 */
	public function isHttpGet(): bool
    {
		return $this->getHttpMethod() === static::HTTP_GET;
	}

	/**
	 * Checks if Http method is POST
	 * 
	 * @return boolean
	 */
	public function isHttpPost(): bool
    {
		return $this->getHttpMethod() === static::HTTP_POST;
	}

    /**
     * Returns User Agent for request
     * 
     * @return string
     */
    public function getUserAgent(): string
    {
        return $this->getHeaders()->get('User-Agent');
    }

    /**
	 * Sets the Http method, only GET or POST are actually supported
	 * 
	 * @param string $httpMethod Can be GET or POST
	 * @return $this
     * @throws InvalidArgumentException
     * @throws RuntimeException
	 */
	public function setHttpMethod(string $httpMethod): static
    {
		if (!static::isHttpMethodSupported($httpMethod)) {
			throw new RuntimeException('Unsupported http method supplied: ' . $httpMethod);
		}

		$this->httpMethod = $httpMethod;
		return $this;
	}

    /**
     * Sets new User Agent for request
     * 
     * @param string $userAgent
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setUserAgent(string $userAgent): static
    {
        $this->getHeaders()->add('User-Agent', $userAgent, true);
        return $this;
    }

    /**
     * Checks if current method is a supported http method
     * 
     * @static
     * @param string $method Http method to check
     * @return bool
     */
    public static function isHttpMethodSupported(string $method): bool
    {
        return in_array(
            strtoupper($method),
            [static::HTTP_GET, static::HTTP_POST]
        );
    }
}