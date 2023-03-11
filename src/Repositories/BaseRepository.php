<?php

namespace App\Repositories;

use PDO;
use Dotenv\Dotenv;

abstract class BaseRepository
{
    private string $host;
    private string $user;
    private string $pass;
    private string $dbname;
    private int $status;
    protected PDO $conn;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->safeLoad();
        $this->host = $this->getenv('DB_HOST');
        $this->user = $this->getenv('DB_USER');
        $this->pass = $this->getenv('DB_PASSWORD');
        $this->dbname = $this->getenv('DB_NAME');
        $this->conn = $this->connect();
    }

    private function getenv(string $attr): string
    {
        $string = trim($_ENV[$attr], ' ');
        $string = trim($_ENV[$attr], '\'');
        $string = trim($_ENV[$attr], '"');

        return (string) $string;
    }

    /**
     * @param int $status
     * 
     * @return void
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return PDO
     */
    private function connect(): PDO
    {
        $conn_str = "mysql:host=$this->host;dbname=$this->dbname";
        $conn = new PDO($conn_str, $this->user, $this->pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }

    /**
     * @param int $input
     * 
     * @return mixed
     */
    protected function sanitizeInt(int $input): mixed
    {
        return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * @param float $input
     * 
     * @return mixed
     */
    protected function sanitizeFloat(float $input): mixed
    {
        return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT);
    }

    /**
     * @param string $input
     * 
     * @return mixed
     */
    protected function sanitizeString(string $input): mixed
    {
        return filter_var($input, FILTER_SANITIZE_STRING);
    }

    /**
     * @param string $input
     * 
     * @return mixed
     */
    protected function sanitizeEmail(string $input): mixed
    {
        return $this->sanitizeString(filter_var($input, FILTER_SANITIZE_EMAIL));
    }
}
