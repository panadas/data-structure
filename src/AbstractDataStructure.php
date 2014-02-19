<?php
namespace Panadas\DataStructure;

abstract class AbstractDataStructure implements \Countable, \IteratorAggregate, \JsonSerializable, \Serializable
{

    protected $params = [];

    abstract public function merge($params);

    abstract public function replace($params);

    abstract public function sort($flags = SORT_REGULAR);

    abstract public function usort(callable $callback);

    public function jsonSerialize()
    {
        return $this->all();
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->params);
    }

    public function count()
    {
        return count($this->all());
    }

    public function serialize()
    {
        return serialize($this->all());
    }

    public function unserialize($data)
    {
        $this->replace(unserialize($data));
    }

    public function populated()
    {
        return ($this->count() > 0);
    }

    public function all()
    {
        return $this->params;
    }

    public function bind(&$params)
    {
        $this->params = $params;

        return $this;
    }

    public function clear()
    {
        $this->params = [];

        return $this;
    }
}
