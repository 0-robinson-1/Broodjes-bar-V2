<?php

declare(strict_types=1);

class Status
{
    private int $bestelId;
    private string $status;

    public function __construct(int $bestelId, string $status)
    {
        $this->bestelId = $bestelId;
        $this->status = $status;
    }

    public static function createStatus(
        int $bestelId, string $status
    ): Status
    {
        return new Status($bestelId, $status);
    }

    public function getBestelId(): int
    {
        return $this->bestelId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}

/*
-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `statussen`
--

CREATE TABLE `statussen` (
  `bestelId` int(6) NOT NULL PRIMARY KEY,
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  FOREIGN KEY (`bestelId`) REFERENCES `bestellingen`(`bestelId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------
*/

?>