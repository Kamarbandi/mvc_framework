<?php

declare(strict_types=1);

namespace Model;

use Exception;
use PDO;
use PDOException;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
 */
trait Database
{
    private ?PDO $connection = null;

    /**
     * @return PDO
     * @throws Exception
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    private function connect(): PDO
    {
        if ($this->connection === null) {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DATABASE_NAME . ";charset=utf8";
            try {
                $this->connection = new PDO($dsn, USER_NAME, PASSWORD, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_PERSISTENT => true
                ]);
            } catch (PDOException $e) {
                throw new Exception('Connection failed: ' . $e->getMessage());
            }
        }
        return $this->connection;
    }

    /**
     * Executes a query and returns the result as an array of objects.
     *
     * @param string $query - The SQL query to execute.
     * @param array $data - The parameters to bind to the query.
     *
     * @return array|false - An array of objects on success, or false on failure.
     * @throws Exception
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function query(string $query, array $data = []): array|false
    {
        try {
            $stm = $this->connect()->prepare($query);
            $stm->execute($data);
            return $stm->fetchAll(PDO::FETCH_OBJ) ?: [];
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * @param string $query
     * @param array $data
     * @return object|false
     * @throws Exception
     * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
     */
    public function get_row(string $query, array $data = []): object|false
    {
        try {
            $stm = $this->connect()->prepare($query);
            $stm->execute($data);
            $result = $stm->fetch(PDO::FETCH_OBJ);
            return $result ?: false;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
