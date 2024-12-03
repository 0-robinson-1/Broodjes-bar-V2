<?php

declare(strict_types=1);

class Bestelling
{
    private int $bestelId;
    private int $broodjeId;
    private int $klantId;
    private DateTime $tijd;

    public function __construct(int $bestelId, int $broodjeId, int $klantId, DateTime $tijd)
    {
        $this->bestelId = $bestelId;
        $this->broodjeId = $broodjeId;
        $this->klantId = $klantId;
        $this->tijd = $tijd;
    }

    public static function createBestelling(
        int $bestelId, int $broodjeId, int $klantId, DateTime $tijd
    ): Bestelling
    {
        return new Bestelling($bestelId, $broodjeId, $klantId, $tijd);
    }

    public function getBestelId(): int
    {
        return $this->bestelId;
    }

    public function getBroodjeId(): int
    {
        return $this->broodjeId;
    }

    public function getKlantId(): int
    {
        return $this->klantId;
    }

    public function getTijd(): DateTime
    {
        return $this->tijd;
    }
}

/*
-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestellingen`
--

CREATE TABLE `bestellingen` (
  `bestelId` int(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `broodjeId` int(6) DEFAULT NULL,
  `klantId` int(6) DEFAULT NULL,
  `tijd` Datetime NOT NULL,
  FOREIGN KEY (`broodjeId`) REFERENCES `broodjes`(`broodjeId`) ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (`klantId`) REFERENCES `klanten`(`klantId`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `bestellingen` ADD INDEX (`broodjeId`);
ALTER TABLE `bestellingen` ADD INDEX (`klantId`);
-- --------------------------------------------------------
*/
?>