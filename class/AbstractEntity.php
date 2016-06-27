<?php

/**
 * Created by PhpStorm.
 * User: nicop
 * Date: 26/06/16
 * Time: 21:55
 */
class AbstractEntity implements ArrayAccess
{
    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return property_exists(get_called_class(), $offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->$offset;
        }

        throw new InvalidArgumentException(sprintf('%s:%s property is not defined', get_called_class(), $offset));
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if ($this->offsetExists($offset)) {
            $setMethodName = sprintf('set%s', ucfirst($offset));
            if (method_exists(get_called_class(), $setMethodName)) {
                return $this->$setMethodName($value);
            } else {
                $this->$offset = $value;
            }
        }

        return false;
        throw new InvalidArgumentException(sprintf('%s:%s property is not defined', get_called_class(), $offset));
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset))
            $this->offsetSet($offset, null);
    }

}