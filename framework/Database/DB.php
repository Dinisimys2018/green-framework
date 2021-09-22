<?php

namespace GF\Database;


class DB
{
    static public function execute(string $rawSQL,string $connection = 'default'):int
    {
        return Connections::getInstance()->getOrSet($connection)->exec($rawSQL);
    }

    static public function executePrepare(
        string $rawSQL,
        array $params = [],
        ?string $dtoClass = null,
        string $connection = 'default'
    )
    {
        $sth = Connections::getInstance()->getOrSet($connection)->prepare($rawSQL);
        $sth->execute($params);
        if(is_null($dtoClass)) {
            return $sth->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return $sth->fetchAll(\PDO::FETCH_CLASS,$dtoClass);
        }
    }
}