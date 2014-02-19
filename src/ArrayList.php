<?php
namespace Panadas\DataStructure;

use Panadas\Util\Php;

class ArrayList extends AbstractDataStructure
{

    public function __toString()
    {
        $lines = [];

        foreach ($this as $item) {
            $lines[] = Php::toString($item);
        }

        return implode(PHP_EOL, $lines);
    }

    protected function validate($item)
    {
        return true;
    }

    protected function filter(&$item)
    {
    }

    public function merge($params)
    {
        foreach ($params as $param) {
            $this->append($item);
        }

        return $this;
    }

    public function replace($params)
    {
        $this->clear();

        foreach ($params as $item) {
            $this->append($item);
        }

        return $this;
    }

    public function sort($flags = SORT_REGULAR)
    {
        sort($this->params, $flags);

        return $this;
    }

    public function usort(callable $callback)
    {
        usort($this->params, $callback);

        return $this;
    }

    public function has($item, $strict = false)
    {
        $this->filter($item);

        return (null !== $this->offset($item, $strict));
    }

    public function hasOffset($offset)
    {
        if (($offset < 0) && $this->populated()) {
            $offset = ($this->count() + $offset);
        }

        return array_key_exists($offset, $this->all());
    }

    public function get($offset, $default = null)
    {
        if (($offset < 0) && $this->populated()) {
            $offset = ($this->count() + $offset);
        }

        return $this->hasOffset($offset) ? $this->params[$offset] : $default;
    }

    public function prepend($item)
    {
        $this->filter($item);

        if ($this->validate($item)) {
            array_unshift($this->params, $item);
        }

        return $this;
    }

    public function append($item)
    {
        $this->filter($item);

        if ($this->validate($item)) {
            $this->params[] = $item;
        }

        return $this;
    }

    public function shift()
    {
        $item = $this->first();

        if (null === $item) {
            $this->remove($item);
        }

        return $item;
    }

    public function pop()
    {
        $item = $this->last();

        if (null === $item) {
            $this->remove($item);
        }

        return $item;
    }

    public function remove($item, $strict = false)
    {
        $this->filter($item);

        $offset = $this->offset($item, $strict);

        if (null !== $offset) {
            unset($this->params[$offset]);
        }

        return $this;
    }

    public function first($default = null)
    {
        return $this->get(0, $default);
    }

    public function last($default = null)
    {
        return $this->get(-1, $default);
    }

    public function offset($item, $strict = false)
    {
        $this->filter($item);

        $offset = array_search($item, $this->all(), $strict);

        return (false !== $offset) ? $offset : null;
    }
}
