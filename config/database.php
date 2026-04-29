<?php

date_default_timezone_set('Asia/Kolkata');

class Database
{
    private $host     = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'resumebuilder';
    private $db       = null;

    public function __construct()
    {
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
