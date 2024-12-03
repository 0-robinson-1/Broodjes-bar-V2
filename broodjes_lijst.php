<?php

declare(strict_types=1);

require_once "database.php";
require_once "broodje.php";

// Establish database connection
$db = new Database();
$conn = $db->connect();

if (!$conn) {
    die("Failed to connect to the database");
}

class BroodjesLijst
{
    private mysqli $conn;

    // Constructor accepts the database connection
    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function getBroodjes(): array
    {
        $query = "SELECT broodjeId, broodje, omschrijving, prijs FROM broodjes";
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            die("Database query failed: " . $this->conn->error);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Fetch all rows at once as an associative array
        $data = $result->fetch_all(MYSQLI_ASSOC);
        
        $broodjes = [];
        // Iterate over the rows using foreach
        foreach ($data as $row) {
            $broodjes[] = Broodje::createBroodje(
                (int)$row['broodjeId'],
                $row['broodje'],
                $row['omschrijving'],
                (float)$row['prijs']
            );
        }
        
        $stmt->close();
        return $broodjes;
    }


        }

$db->disconnect();

?>