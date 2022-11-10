<?php

namespace App\Libs\Enums;

abstract class Enum
{
    protected $value;

    public function __construct($value)
    {
        $this->value = self::isValidValue($value) ? (int) $value : null;
    }

    public function __toString()
    {
        return $this->getLabel();
    }

    public static function getConstants()
    {
        $oClass = new \ReflectionClass(get_called_class());

        return $oClass->getConstants();
    }

    public static function getAll()
    {
        $class = get_called_class();
        $values = [];
        foreach (self::getConstants() as $key => $value) {
            $values[] = new $class($value);
        }

        return $values;
    }

    public static function isValidValue($value)
    {
        return in_array($value, self::getConstants());
    }

    public function getLabel()
    {
        $labels = $this->getLabels();
        if (array_key_exists($this->value, $labels)) {
            return $labels[$this->value];
        }

        return $this->getKey();
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getKey()
    {
        $constants = self::getConstants();

        return (string) array_search($this->value, $constants);
    }

    public function is($value)
    {
        if ($value instanceof Enum) {
            return $value->getValue() === $this->getValue();
        }

        return $this->getValue() === $value;
    }

    protected function getLabels()
    {
        return [];
    }
}
