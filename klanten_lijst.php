<?php

declare(strict_types=1);

require_once "database.php";
require_once "klant.php";

// Establish database connection
$db = new Database();
$conn = $db->connect();

if (!$conn) {
    die("Failed to connect to the database");
}

class KlantenLijst
{
    private mysqli $conn;

    // Constructor accepts the database connection
    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }


    public function getKlantById(int $klantId): Klant
    {
        $query = "SELECT klantId, voornaam, achternaam, emailadres FROM klanten WHERE klantId = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $this->conn->error);
        }

        $stmt->bind_param("i", $klantId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Klant(
                (int)$row['klantId'],
                $row['voornaam'],
                $row['achternaam'],
                $row['emailadres']
            );
        }

        throw new Exception("Klant with ID $klantId not found.");
    }
}

$db->disconnect();

?>