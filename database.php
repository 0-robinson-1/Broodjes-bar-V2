<?php

declare(strict_types=1);

class Database
{
    private ?mysqli $conn = null;

    public function connect(): ?mysqli {
        if ($this->conn === null) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "broodjesbar_Robin_V2";

            $this->conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        }
        return $this->conn;
    }

    public function disconnect(): void {
        if ($this->conn !== null) {
            $this->conn->close();
            $this->conn = null;
        }
    }
}
?>