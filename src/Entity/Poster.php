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
    private ?string $jpeg;

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

    /** Search the poster by his id.
     *
     * @param int $id The poster id.
     * @return Poster The poster.
     * @throws EntityNotFoundException If no Poster was found.
     */
    public static function findById(int $id): Poster
    {

        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT *
            FROM poster
            WHERE id = :id
            SQL
        );
        $stmt->bindValue(':id', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Poster::class);
        $stmt-> execute();
        if(($resp = $stmt->fetch()) === false){
            throw new EntityNotFoundException();
        }
        return $resp;
    }
}