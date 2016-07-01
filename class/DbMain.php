<?php

namespace Recipy\Db;

/**
 * Class dbmain
 */
class DbMain extends DatabaseAbstract
{

    public function pagination($statement, $params = [], $limit = 1, $offset = 0)
    {
        $statementTmp = $statement . ' LIMIT ' . $offset . ',' . $limit . ';';
        /** @var \PDOStatement $sth */
        $sth = parent::prepare($statementTmp);
        $sth->execute($params);

        $result = $sth->fetchAll(\PDO::FETCH_CLASS);
        $sth = parent::prepare($statementTmp);
        $sth->execute($params);

        $count = count($sth->fetchAll(\PDO::FETCH_CLASS));
        $page_count = ($limit !== 0) ? $count / $limit : 0;

        return ['datas' => $result, 'row_count' => $count, 'page_count' => $page_count];
    }
}