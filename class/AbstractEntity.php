<?php

namespace Recipy\Entity;

use Recipy\Db\DbManager;
use Recipy\Db\SPdo;

/**
 * Class AbstractEntity
 * @package Recipy\Entity
 */
class AbstractEntity implements \ArrayAccess
{
    protected $query = null;
    protected $params = [];

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

    /**
     * @param array $params
     *
     * @return $this
     */
    public function setParams(array $params = [])
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @return \PDOStatement
     */
    public function execute()
    {
        $db = DbManager::getInstanceOf();
        /** @var \PDOStatement $sth */
        $sth = $db->prepare($this->query);
        $sth->execute($this->params);

        $this->query = null;
        $this->params = [];
        return $sth;
    }

    public function getPagination()
    {
        $query = "SELECT FOUND_ROWS() as count;";
        $result = DbManager::getInstanceOf()->query($query)->fetchAll();
        $count = $result[0]['count'];
        return $count;
    }

    /**
     * @param string|null $query
     * @param int         $limit
     * @param int         $offset
     *
     * @return $this|string
     */
    public function limit($limit = 0, $offset = 0, $query = null)
    {
        $limitQuery = ' LIMIT ' . $offset . ',' . $limit;
        if (!empty($query)) {
            return $query . $limitQuery;
        }
        $this->query .= $limitQuery;

        return $this;
    }

    /**
     * @param       $query
     * @param array $params
     * @param int   $limit
     * @param int   $offset
     *
     * @return array|bool|string
     */
    protected function query($query, $params = [], $limit = 0, $offset = 0)
    {
        if ($limit > 0)
            $query = $this->limit($limit, $offset, $query);

        return SPdo::getInstance()->query($query, $params);
    }

    /**
     * @deprecated
     *
     * @param       $query
     * @param array $params
     *
     * @return \PDOStatement
     */
    public function executeQuery($query, $params = [])
    {
        $db = DbManager::getInstanceOf();
        /** @var \PDOStatement $sth */
        $sth = $db->prepare($query);
        $sth->execute($params);

        return $sth;
    }
}