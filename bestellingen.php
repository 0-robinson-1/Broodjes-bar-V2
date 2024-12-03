<?php

declare(strict_types = 1);

// Enable error reporting
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once 'bestellingen_lijst.php';
require_once 'klanten_lijst.php';
require_once 'statussen_lijst.php';

// Establish database connection
$db = new Database();
$conn = $db->connect();

if (!$conn) {
    die("Failed to connect to the database");
}

// Instantiate the classes with the connection
$bestellingenLijst = new BestellingenLijst($conn);
$klantenLijst = new KlantenLijst($conn);
$statussenLijst = new StatussenLijst($conn);

// Fetch the data
$allBestellingen = $bestellingenLijst->getBestellingen();
$bestellingen = array_filter($allBestellingen, function ($bestelling) use ($statussenLijst) {
    $status = $statussenLijst->getStatusByBestelId($bestelling->getBestelId());
    return $status !== 'Afgehaald';
});

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/main.css">
    <title>Bestellingen</title>
</head>
<body style="text-align: center;">
<div class="grid">
    <div>
        <h1>Bestellingen</h1>

        <!-- Add button to navigate to broodjes.php -->
        <button onclick="window.location.href='broodjes.php'" style="margin-top: 0px; padding: 0px 3px; font-size: 14px;">
            Ga naar Broodjes
        </button>

        <!-- Add a white rule below the button -->
        <hr style="border: none; height: 1px; background-color: white; margin: 5px auto; width: 80%;">

        <?php if (empty($bestellingen)): ?>
            <p>Geen bestellingen...</p>
        <?php else: ?>
            <table border="1" cellpadding="2" cellspacing="2" align="center">
                <thead>
                <tr>
                    <th>bestelId</th>
                    <th>voornaam</th>
                    <th>achternaam</th>
                    <th>tijd</th>
                    <th>status</th>
                    <th>actie</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bestellingen as $bestelling): ?>
                    <?php
                    // Fetch the klant object using the klantId from the bestelling
                    $klant = $klantenLijst->getKlantById($bestelling->getKlantId());
                    $status = $statussenLijst->getStatusByBestelId($bestelling->getBestelId());
                    ?>
                    <tr>
                        <td><?= $bestelling->getBestelId(); ?></td>
                        <td><?= $klant->getVoornaam(); ?></td>
                        <td><?= $klant->getAchternaam(); ?></td>
                        <td><?= $bestelling->getTijd()->format('Y-m-d H:i:s'); ?></td>
                        <td><?= $status; ?></td>
                        <td>
                            
                        <!-- Determine action based on current status -->
                        <?php if ($status === 'Besteld'): ?>
                            <!-- Button to mark as Gemaakt -->
                            <form method="POST" action="statussen_lijst.php">
                                <input type="hidden" name="bestelId" value="<?= $bestelling->getBestelId(); ?>">
                                <input type="hidden" name="status" value="Gemaakt">
                                <button type="submit">Markeer als Gemaakt</button>
                            </form>
                        <?php elseif ($status === 'Gemaakt'): ?>
                            <!-- Button to mark as Afgehaald -->
                            <form method="POST" action="statussen_lijst.php">
                                <input type="hidden" name="bestelId" value="<?= $bestelling->getBestelId(); ?>">
                                <input type="hidden" name="status" value="Afgehaald">
                                <button type="submit">Markeer als Afgehaald</button>
                            </form>
                        <?php elseif ($status === 'Afgehaald'): ?>
                            <!-- No further action needed -->
                            <span>Geen actie nodig</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
</body>
</html>