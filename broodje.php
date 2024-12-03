<?php

declare(strict_types=1);

class Broodje
{
    private int $broodjeId;
    private string $broodje;
  private string $omschrijving;
    private float $prijs;

    public function __construct(int $broodjeId, string $broodje, string $omschrijving, float $prijs)
    {
        $this->broodjeId = $broodjeId;
        $this->broodje = $broodje;
        $this->omschrijving = $omschrijving;
        $this->prijs = $prijs;
    }

    public static function createBroodje(
        int $broodjeId, string $broodje, string $omschrijving, float $prijs
        ): Broodje
    {
        return new Broodje($broodjeId, $broodje, $omschrijving, $prijs,);
    }

    public function getBroodjeId(): int
    {
        return $this->broodjeId;
    }

    public function getBroodje(): string
    {
        return $this->broodje;
    }

    public function getOmschrijving(): string
    {
        return $this->omschrijving;
    }

    public function getPrijs(): float
    {
        return $this->prijs;
    }

} 


/*
-- Tabelstructuur voor tabel `broodjes`
--

CREATE TABLE `broodjes` (
  `broodjeId` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `broodje` varchar(50) NOT NULL,
  `omschrijving` varchar(500) NOT NULL,
  `prijs` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `broodjes`
--

INSERT INTO `broodjes` (`broodjeId`, `broodje`, `omschrijving`, `prijs`) VALUES
(1, 'Kaas', 'Broodje met jonge kaas', 1.90),
(2, 'Ham', 'Broodje met natuurham', 1.90),
(3, 'Kaas en ham', 'Broodje met kaas en ham', 2.10),
(4, 'Fitness kip', 'kip natuur, yoghurtdressing, perzik, tuinkers, tomaat en komkommer', 3.50),
(5, 'Broodje Sombrero', 'kip natuur, andalousesaus, rode paprika, maïs, sla, komkommer, tomaat, ei en ui ', 3.70),
(6, 'Broodje americain-tartaar', 'americain, tartaarsaus, ui, komkommer, ei en tuinkers ', 3.50),
(7, 'Broodje Indian kip', 'kip natuur, ananas, tuinkers, komkommer en curry dressing', 4.00),
(8, 'Grieks broodje', 'feta, tuinkers, komkommer, tomaat en olijventapenade', 3.90),
(9, 'Tonijntino', 'tonijn pikant, ui, augurk, martinosaus en (tabasco)', 2.60),
(10, 'Wrap exotisch', 'kip natuur, cocktailsaus, sla, tomaat, komkommer, ei en ananas', 3.70),
(11, 'Wrap kip/spek', 'Kip natuur, spek, BBQ saus, sla, tomaat en komkommer', 4.00);

*/

?>