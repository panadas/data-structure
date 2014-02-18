<?php
namespace Panadas\DataStructureModule;

class Set extends ArrayList
{

    protected function validate($item)
    {
        return !$this->has($item, true);
    }
}
