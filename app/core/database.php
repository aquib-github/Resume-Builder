<?php
// Database Connection — credentials loaded from .env

class Database
{
    private $host;
    private $username;
    private $password;
    private $database;
    private $db = null;

    public function __construct()
    {
        $this->host     = $_ENV['DB_HOST']     ?? 'localhost';
        $this->username = $_ENV['DB_USERNAME']  ?? 'root';
        $this->password = $_ENV['DB_PASSWORD']  ?? '';
        $this->database = $_ENV['DB_NAME']      ?? 'resumebuilder';

        $this->db = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->db->connect_error) {
            http_response_code(500);
            die('Database connection failed. Please try again later.');
        }

        $this->db->set_charset('utf8mb4');
    }

    public function connect()
    {
        return $this->db;
    }
}

$db = new Database();
$db = $db->connect();
