<?php

namespace App\Database\Contract;

class Connection
{
    private string $db_server = 'localhost';
    private string $db_username = 'root';
    private string $db_password = '';
    private string $db_name = 'ecommerce';
    private int $db_port = 3306;
    public \mysqli $conn;

    public function __construct()
    {
        $this->conn = new \mysqli(
            $this->db_server,
            $this->db_username,
            $this->db_password,
            $this->db_name,
            $this->db_port
        );
    }
}
