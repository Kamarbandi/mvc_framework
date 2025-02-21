<?php

namespace App;

use App\Helpers\ErrorLogger;

trait Database
{
    /**
     * Establishes a connection to the database using PDO.
     *
     * @return \PDO
     * @throws \PDOException if the connection fails.
     */
    private function connect(): \PDO
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";

        try {
            $pdo = new \PDO($dsn, DB_USER, DB_PASS, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, // Enable exceptions on errors
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ, // Fetch as object by default
                \PDO::ATTR_PERSISTENT => true, // Use persistent connections
            ]);
            return $pdo;
        } catch (\PDOException $e) {
            // Log error or handle it appropriately
            ErrorLogger::logException($e);
            exit("Database connection failed: " . $e->getMessage());
        }
    }


    /**
     * Executes a database query and returns all rows.
     *
     * @param string $query The SQL query string.
     * @param array $params Parameters for prepared statement (optional).
     * @return array|false An array of objects if rows exist, or false on failure.
     */
    public function query(string $query, array $params = []): array|false
    {
        $pdo = $this->connect();
        $stmt = $pdo->prepare($query);

        if ($stmt->execute($params)) {
            $result = $stmt->fetchAll();
            return $result ?: false;
        }

        return false;
    }

    /**
     * Executes a database query and returns a single row.
     *
     * @param string $query The SQL query string.
     * @param array $params Parameters for prepared statement (optional).
     * @return object|false A single object if a row exists, or false on failure.
     */
    public function get_row(string $query, array $params = []): object|false
    {
        $pdo = $this->connect();
        $stmt = $pdo->prepare($query);

        if ($stmt->execute($params)) {
            $result = $stmt->fetch();
            return $result ?: false; // Return a single result or false if none
        }

        return false;
    }
}