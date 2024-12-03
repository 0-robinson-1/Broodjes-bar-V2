<?php

declare(strict_types=1);

require_once "database.php";
require_once "status.php";

// Establish database connection
$db = new Database();
$conn = $db->connect();

if (!$conn) {
    die("Failed to connect to the database");
}

// Instantiate the class
$statussenLijst = new StatussenLijst($conn);

// Handle form submission to update status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bestelId'], $_POST['status'])) {
    $bestelId = (int)$_POST['bestelId'];
    $status = trim($_POST['status']);

    $statussenLijst->updateStatus($bestelId, $status);

    // Redirect to prevent form resubmission
    header("Location: bestellingen.php");
    exit;
}

class StatussenLijst
{
    private mysqli $conn;

    // Constructor accepts the database connection
    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function getStatusByBestelId(int $bestelId): string
{
    $query = "SELECT status FROM statussen WHERE bestelId = ?";
    $stmt = $this->conn->prepare($query);

    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $this->conn->error);
    }

    $stmt->bind_param("i", $bestelId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        return $row['status'];
    }

    return "Unknown"; // Default or fallback value
}
        // Add method to update status

        public function updateStatus(int $bestelId, string $status): void
        {
            // Prepare the SQL query for updating the status
            $query = "UPDATE statussen SET status = ? WHERE bestelId = ?";
            $stmt = $this->conn->prepare($query);
        
            // Check if the statement was successfully prepared
            if (!$stmt) {
                throw new Exception("Failed to prepare statement: " . $this->conn->error);
            }
        
            // Bind parameters and execute the statement
            $stmt->bind_param("si", $status, $bestelId);
            if (!$stmt->execute()) {
                throw new Exception("Failed to execute statement: " . $stmt->error);
            }
        
            // Close the statement
            $stmt->close();
        }

    }
$db->disconnect();

?>