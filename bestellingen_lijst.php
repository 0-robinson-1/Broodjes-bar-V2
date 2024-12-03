<?php

declare(strict_types=1);

require_once "database.php";
require_once "bestelling.php";

// Establish database connection
$db = new Database();
$conn = $db->connect();

if (!$conn) {
    die("Failed to connect to the database");
}

class BestellingenLijst
{
    private mysqli $conn;

    // Constructor accepts the database connection
    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function getBestellingen(): array
    {
        $query = "SELECT 
                      b.bestelId, 
                      b.broodjeId, 
                      b.klantId, 
                      b.tijd, 
                      st.status,
                      k.voornaam, 
                      k.achternaam
                  FROM bestellingen AS b
                  JOIN klanten AS k ON b.klantId = k.klantId
                  JOIN statussen AS st ON b.bestelId = st.bestelId";
    
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            die("Failed to prepare statement: " . $this->conn->error);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
    
        $bestellingen = [];
        foreach ($data as $row) {
            $bestellingen[] = Bestelling::createBestelling(
                (int)$row['bestelId'],
                (int)$row['broodjeId'],
                (int)$row['klantId'], // Ensure klantId is cast to int
                new DateTime($row['tijd']),
                $row['status']
            );
        }
    
        $stmt->close();
        return $bestellingen;
    }
    
    public function addBestelling(int $broodjeId, string $voornaam, string $achternaam, string $emailadres, DateTime $tijd, string $status): string
    {
        // Start a transaction
        $this->conn->begin_transaction();
    
        try {
            // Step 1: Check if the customer already exists in the `klanten` table
            $stmt = $this->conn->prepare("SELECT klantId FROM klanten WHERE emailadres = ?");
            if (!$stmt) {
                throw new Exception("Failed to prepare statement for checking klant: " . $this->conn->error);
            }
            $stmt->bind_param("s", $emailadres);
            $stmt->execute();
            $result = $stmt->get_result();
    
            $klantId = null;
            if ($result->num_rows > 0) {
                // Customer exists, get the `klantId`
                $row = $result->fetch_assoc();
                $klantId = $row['klantId'];
            } else {
                // Customer does not exist, insert into `klanten` table
                $stmtInsertKlant = $this->conn->prepare("INSERT INTO klanten (voornaam, achternaam, emailadres) VALUES (?, ?, ?)");
                if (!$stmtInsertKlant) {
                    throw new Exception("Failed to prepare statement for inserting klant: " . $this->conn->error);
                }
                $stmtInsertKlant->bind_param("sss", $voornaam, $achternaam, $emailadres);
                $stmtInsertKlant->execute();
                $klantId = $this->conn->insert_id;
            }
    
            // Step 2: Insert the order into the `bestellingen` table
            $stmtInsertOrder = $this->conn->prepare("INSERT INTO bestellingen (broodjeID, klantID, tijd) VALUES (?, ?, ?)");
            if (!$stmtInsertOrder) {
                throw new Exception("Failed to prepare statement for bestellingen: " . $this->conn->error);
            }
            $formattedTijd = $tijd->format('Y-m-d H:i:s');
            $stmtInsertOrder->bind_param("iis", $broodjeId, $klantId, $formattedTijd);
            $stmtInsertOrder->execute();
    
            // Step 3: Insert the status into the `statussen` table
            $bestelId = $this->conn->insert_id; // Get the auto-incremented `bestelId`
            $stmtInsertStatus = $this->conn->prepare("INSERT INTO statussen (bestelID, Status) VALUES (?, ?)");
            if (!$stmtInsertStatus) {
                throw new Exception("Failed to prepare statement for statussen: " . $this->conn->error);
            }
            $stmtInsertStatus->bind_param("is", $bestelId, $status);
            $stmtInsertStatus->execute();
    
            // Commit the transaction
            $this->conn->commit();
            return "Success: Your order has been placed.";
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}

$db->disconnect();

?>