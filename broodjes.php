<?php

declare(strict_types=1);

// Enable error reporting
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once "broodjes_lijst.php";
require_once "bestellingen_lijst.php";

// Establish database connection
$db = new Database();
$conn = $db->connect();

if (!$conn) {
    die("Failed to connect to the database");
}

// Pass the connection to the constructor
$broodjesLijst = new BroodjesLijst($conn);
$bestellingenLijst = new BestellingenLijst($conn);

// Initialize a feedback message variable
$message = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and validate the form data
    $broodjeId = isset($_POST['broodje']) ? (int)$_POST['broodje'] : null;
    $voornaam = isset($_POST['voornaam']) ? trim($_POST['voornaam']) : null;
    $achternaam = isset($_POST['achternaam']) ? trim($_POST['achternaam']) : null;
    $emailadres = isset($_POST['emailadres']) ? trim($_POST['emailadres']) : null;
    $tijd = isset($_POST['tijd']) ? $_POST['tijd'] : null;
    $status = "Besteld"; // Default status for new orders

    if ($tijd) {
        $currentTime = new DateTime();
        try {
            $afhaalmoment = new DateTime($tijd);

            // Check if the selected time is at least 30 minutes in the future
            $interval = $currentTime->diff($afhaalmoment);
            if ($currentTime > $afhaalmoment || ($interval->days === 0 && $interval->h === 0 && $interval->i < 30)) {
                $message = "Error: The pickup time must be at least 30 minutes in the future.";
            }
        } catch (Exception $e) {
            $message = "Error: Invalid or missing time.";
        }
    } else {
        $message = "Error: Invalid or missing time.";
    }

    // Proceed only if there's no error in $message
    if (empty($message)) {
        $status = "Besteld"; // Default status for new orders

        // Check if all required fields are present
        if ($broodjeId && $voornaam && $achternaam && $emailadres && $tijd) {
            try {
                // Add the bestelling
                $message = $bestellingenLijst->addBestelling($broodjeId, $voornaam, $achternaam, $emailadres, $afhaalmoment, $status);
            } catch (Exception $e) {
                $message = "Error: Could not add bestelling. Please try again.";
            }
        } else {
            $message = "Error: All fields are required.";
        }
    }
}

// Fetch the broodjes
$broodjes = $broodjesLijst->getBroodjes();

// Disconnect from the database
$db->disconnect();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Broodjes Bar</title>
</head>
<body style="text-align: center;">
    <h1>Broodjes Bar</h1>

    <!-- Display feedback message -->
        <?php if (!empty($message)): ?>
        <p style="color: <?= strpos($message, 'Error') === false ? 'green' : 'red'; ?>;">
            <?= htmlspecialchars($message); ?>
        </p>
    <?php endif; ?>

    <!-- Add button to navigate to bestellingen.php -->
    <button onclick="window.location.href='bestellingen.php'" style="margin-top: 0px; padding: 0px 3px; font-size: 14px;">
        Ga naar Bestellingen
    </button>

    <!-- Add a white rule below the button -->
    <hr style="border: none; height: 1px; background-color: white; margin: 5px auto; width: 80%;">

        <!-- Display broodjes -->
            <table border="1" cellpadding="2" cellspacing="2" align="center">
                <thead>
                <tr>
                    <th>broodjeId</th>
                    <th>broodje</th>
                    <th>omschrijving</th>
                    <th>prijs</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($broodjes as $broodje): ?>
                    <tr>
                        <td>
                            <?= $broodje->getBroodjeId(); ?>
                        </td>
                        <td>
                            <?= $broodje->getBroodje(); ?>
                        </td>
                        <td>
                            <?= $broodje->getOmschrijving(); ?>
                        </td>
                        <td class="text-right">
                            € <?= number_format($broodje->getPrijs(), 2); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <h2>Add a Bestelling</h2>
    <form method="post" action="">
        <label for="broodje">Broodje :</label>
        <select name="broodje" id="broodje" required>
            <?php foreach ($broodjes as $broodje): ?>
                <option value="<?= $broodje->getBroodjeId(); ?>"><?= $broodje->getBroodje(); ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="voornaam">Voornaam :</label>
        <input type="text" id="voornaam" name="voornaam" required><br><br>

        <label for="achternaam">Achternaam :</label>
        <input type="text" id="achternaam" name="achternaam" required><br><br>

        <label for="emailadres">Emailadres :</label>
        <input type="emailadres" id="emailadres" name="emailadres" required><br><br>

        <label for="tijd">Afhaalmoment :</label>
        <input type="datetime-local" id="tijd" name="tijd" required><br><br>

        <button type="submit">Add Bestelling</button>
    </form>

</body>
</html>