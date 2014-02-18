<?php
namespace Panadas\DataStructure;

use Panadas\Util\Php;

class Hash extends AbstractDataStructure implements \ArrayAccess
{

    public function __toString()
    {
        $lines = [];

        foreach ($this as $key => $value) {
            $value = Php::toString($value);
            $lines[] = "{$key}: {$value}";
        }

        return implode(PHP_EOL, $lines);
    }

    protected function validate($key, $value)
    {
        return true;
    }

    protected function filter(&$key, &$value = null)
    {
    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    public function merge($params)
    {
        foreach ($params as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    public function replace($params)
    {
        $this->clear();

        foreach ($params as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    public function sort($flags = SORT_REGULAR)
    {
        ksort($this->params, $flags);

        return $this;
    }

    public function usort(callable $callback)
    {
        uksort($this->params, $callback);

        return $this;
    }

    public function keys()
    {
        return array_keys($this->all());
    }

    public function has($key)
    {
        $this->filter($key);

        return array_key_exists($key, $this->all());
    }

    public function get($key, $default = null)
    {
        $this->filter($key);

        return $this->has($key) ? $this->params[$key] : $default;
    }

    public function set($key, $value)
    {
        $this->filter($key, $value);

        if ($this->validate($key, $value)) {
            $this->params[$key] = $value;
        }

        return $this;
    }

    public function remove($key)
    {
        $this->filter($key);

        if ($this->has($key)) {
            unset($this->params[$key]);
        }

        return $this;
    }
}
