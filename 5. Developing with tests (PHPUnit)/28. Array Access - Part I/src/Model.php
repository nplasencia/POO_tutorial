<?php

namespace Nplasencia;


abstract class Model
{
    protected $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function fill(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function getAttribute($name)
    {
        $value = $this->getAttributeValue($name);

        if ($this->hasGetMutator($name)) {
            return $this->mutateAttribute($name, $value);
        }

        return $value;
    }

    protected function hasGetMutator($name)
    {
        $method = 'get' . Str::studly($name) . 'Attribute';

        return method_exists($this, $method);
    }

    protected function mutateAttribute($name, $value)
    {
        $method = 'get' . Str::studly($name) . 'Attribute';

        return $this->$method($value);
    }

    public function getAttributeValue($name)
    {
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        }
    }

    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __set($name, $value)
    {
        $this->setAttribute($name, $value);
    }

    public function __get($name)
    {
        return $this->getAttribute($name);
    }

    public function __isset($name)
    {
        return isset($this->attributes[$name]);
    }

    public function __unset($name)
    {
        unset($this->attributes[$name]);
    }
}
