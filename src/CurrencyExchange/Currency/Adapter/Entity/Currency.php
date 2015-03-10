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

/**
 * @Entity @Table(name="currency")
 **/
class Currency
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="string") **/
    protected $entity;

    /** @Column(type="string") **/
    protected $currency;

    /** @Column(type="string") **/
    protected $alphabeticCode;

    /** @Column(type="string") **/
    protected $numericCode;

    /** @Column(type="string") **/
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
    }

    public function __get($name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->{$method}();
        } else {
            return null;
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . ucfirst($name);
        if (method_exists($this, $method)) {
            $this->{$method}($value);
        }
    }
}