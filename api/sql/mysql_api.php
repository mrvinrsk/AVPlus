<?php

class MySQLAPI
{

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function execute($query)
    {
        $statement = $this->connection->prepare($query);
        $statement->execute();
    }

    public function result($query)
    {
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        return $result;
    }

    public function rows($query)
    {
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $rows = $statement->rowCount();

        return $rows;
    }

    public function lastID() {
        return $this->connection->lastInsertId();
    }
}

?>
