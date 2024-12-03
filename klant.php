<?php

declare(strict_types=1);

class klant
{
    private int $klantId;
    private string $voornaam;
    private string $achternaam;
    private string $emailadres;
    
    public function __construct(int $klantId, string $voornaam, string $achternaam, string $emailadres)
    {
        $this->klantId = $klantId;
        $this->voornaam = $voornaam;
        $this->achternaam = $achternaam;
        $this->emailadres = $emailadres;
    }

    public static function createklant(
        int $klantId, string $voornaam, string $achternaam, string $emailadres
    ): klant
    {
        return new klant($klantId, $voornaam, $achternaam, $emailadres);
    }

    public function getklantId(): int
    {
        return $this->klantId;
    }
    
    public function getVoornaam(): string
    {
        return $this->voornaam;
    }

    public function getAchternaam(): string
    {
        return $this->achternaam;
    }

    public function getEmailadres(): string
    {
        return $this->emailadres;
    }
}

/*
-- --------------------------------------------------------
--
-- Tabelstructuur voor tabel `klanten`
--

CREATE TABLE `klanten` (
  `klantId` int(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `voornaam` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `achternaam` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `emailadres` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------
*/

?>