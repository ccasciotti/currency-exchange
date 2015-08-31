<?php

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Http;

use InvalidArgumentException;
use RuntimeException;
use CurrencyExchange\Options;

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
	const HTTP_GET = 'GET';

	/**
	 * Constant for HTTP method POST
	 */
	const HTTP_POST = 'POST';

    /**
     * Constant for Defaut User Agent
     */
    const DEFAULT_USER_AGENT = 'Currency Exchange';

    /**
     * @var string
     */
    protected $_httpMethod;

    /**
     * @var array
     */
    protected $_httpHeaders;

    /**
     * @var CurrencyExchange\Options Request's options
     */
    protected $_options;

    /**
     * Constructor initialize Options object with standard options
     */
    public function __construct()
    {
        $this->_httpMethod = static::HTTP_GET;

        $this->_httpHeaders = new Options();
        $this->_httpHeaders->setOptions([
           'User-Agent' => static::DEFAULT_USER_AGENT,
        ]);

        $this->_options = new Options();
    }

    /**
     * Return current http method
     * 
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->_httpMethod;
    }

    /**
     * Returns Options object
     * 
     * @return CurrencyExchange\Options
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * Returns Options object
     * 
     * @return CurrencyExchange\Options
     */
    public function getHeaders()
    {
        return $this->_httpHeaders;
    }

    /**
	 * Checks if Http method is GET
	 * 
	 * @return boolean
	 */
	public function isHttpGet()
	{
		return $this->getHttpMethod() === static::HTTP_GET;
	}

	/**
	 * Checks if Http method is POST
	 * 
	 * @return boolean
	 */
	public function isHttpPost()
	{
		return $this->getHttpMethod() === static::HTTP_POST;
	}

    /**
     * Returns User Agent for request
     * 
     * @return string
     */
    public function getUserAgent()
    {
        return $this->getHeaders()->get('User-Agent');
    }

    /**
	 * Sets the Http method, only GET or POST are actually supported
	 * 
	 * @param string $httpMethod Can be GET or POST
	 * @return CurrencyExchange\Http\Method
     * @throws InvalidArgumentException
     * @throws RuntimeException
	 */
	public function setHttpMethod($httpMethod)
	{
        if (!is_string($httpMethod)) {
            throw new InvalidArgumentException('Http method must be a string, ' . gettype($httpMethod) . ' given.');
        }

		if (!static::isHttpMethodSupported($httpMethod)) {
			throw new RuntimeException('Unsupported http method supplied: ' . $httpMethod);
		}

		$this->_httpMethod = (string) $httpMethod;
		return $this;
	}

    /**
     * Sets new User Agent for request
     * 
     * @param string $userAgent
     * @return CurrencyExchange\Http\Request
     * @throws InvalidArgumentException
     */
    public function setUserAgent($userAgent)
    {
        if (!is_string($userAgent)) {
            throw new InvalidArgumentException('User Agent must be a string, ' . gettype($userAgent) . ' given.');
        }

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
    public static function isHttpMethodSupported($method)
    {
        return in_array(strtoupper((string) $method), [
            static::HTTP_GET,
            static::HTTP_POST,
        ]);
    }
}