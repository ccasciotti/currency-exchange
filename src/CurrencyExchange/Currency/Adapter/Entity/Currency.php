<?php

/**
 * CurrencyExchange
 * 
 * A library to retrieve currency exchanges using several web services
 * 
 * @link https://github.com/teknoman/currency-exchange
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace CurrencyExchange\Currency\Adapter\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class that represent a currency object downloaded
 * 
 * @ORM\Entity 
 * @ORM\Table(name="currency", indexes={@ORM\Index(name="alphabetic_codes", columns={"alphabeticCode"})})
 * 
 * @package CurrencyExchange
 **/
class Currency
{
    /** 
     * @ORM\Id 
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer") 
     **/
    protected $id;

    /** 
     * @ORM\Column(type="string") 
     **/
    protected $entity;

    /** 
     * @ORM\Column(type="string") 
     **/
    protected $currency;

    /** 
     * @ORM\Column(type="string") 
     **/
    protected $alphabeticCode;

    /** 
     * @ORM\Column(type="string") 
     **/
    protected $numericCode;

    /** 
     * @ORM\Column(type="string") 
     **/
    protected $minorUnit;

    public function getId()
    {
        return $this->id;
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getAlphabeticCode()
    {
        return $this->alphabeticCode;
    }

    public function getNumericCode()
    {
        return $this->numericCode;
    }

    public function getMinorUnit()
    {
        return $this->minorUnit;
    }

    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    public function setAlphabeticCode($alphabeticCode)
    {
        $this->alphabeticCode = $alphabeticCode;
    }

    public function setNumericCode($numericCode)
    {
        $this->numericCode = $numericCode;
    }

    public function setMinorUnit($minorUnit)
    {
        $this->minorUnit = $minorUnit;
    }

    /**
     * Hydrate object with properties of other object/array
     * 
     * @param mixed $element Object or array
     * @return CurrencyExchange\Currency\Adapter\Entity\Currency
     */
    public function hydrate($element)
    {
        if (is_object($element)) {
            foreach (get_object_vars($element) as $key => $value) {
                $this->__set($key, $value);
            }
        } else if (is_array($element)) {
            foreach ($element as $key => $value) {
                $this->__set($key, $value);
            }
        }

        return $this;
    }

    /**
     * If a setter method with composed name is found, is invoked
     * 
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $method = 'set' . ucfirst($name);
        if (method_exists($this, $method)) {
            $this->{$method}($value);
        }
    }
}