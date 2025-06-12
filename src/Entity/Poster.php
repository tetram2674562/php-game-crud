<?php

// Albin Blachon

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Exception\EntityNotFoundException;
use PDO;

class Poster
{
    private int $id;
    private string $jpeg;

    /**
     * @return string The jpeg data.
     */
    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    /**
     * @return int The id.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** Find a poster by his id.
     *
     * @param int $id The poster id.
     * @return Poster The poster founded.
     * @throws EntityNotFoundException If no poster founded.
     */
    public static function findById(int $id): Poster
    {
        // Prepare request
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT *
            FROM poster
            WHERE id = :posterId
            SQL
        );
        $stmt->bindValue(':posterId', $id);
        $stmt->execute();
        // Fetch the restult
        $stmt->setFetchMode(PDO::FETCH_CLASS, Poster::class);
        if (($result = $stmt->fetch()) === false) {
            throw new EntityNotFoundException();
        }
        return $result;
    }
}
