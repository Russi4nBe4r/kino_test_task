<?php

namespace App\Database;

use Exception;

class Database
{
    private $host = 'localhost';
    private $user = 'terehov';
    private $password = 'AlphaOm33XdS';
    private $name = 'demo';

    private $conn = null;

    public function __construct()
    {
        try
		{
			$this->conn = new \PDO("mysql:host=$this->host;dbname=$this->name", $this->user, $this->password);
		}
		catch(\PDOException $e)
		{
			throw new \Exception($e->getMessage());
		}
    }

    public function __destruct()
    {
        $this->conn = null;
    }

    public function execute($sql)
    {
        try {
            $this->conn->exec($sql);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function query($sql)
    {
        $dbData = $this->conn->query($sql);
        $dbData->setFetchMode(\PDO::FETCH_ASSOC);

        return $dbData->fetchAll();
    }
}