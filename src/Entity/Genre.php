<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Exception\EntityNotFoundException;
use PDO;

class Genre
{
    private int $id;
    private string $desc;

    /** A function that allows to find a genre by It's ID
     *
     * @param int $id The id.
     * @return Genre the corresponding genre
     * @throws EntityNotFoundException if the genre was not found inside the database.
     */
    public static function findById(int $id): Genre
    {
        $stmt = MyPdo::getInstance()->prepare(<<< 'SQL'
            SELECT id,name
            FROM genre
            WHERE id = :id
        SQL);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, Genre::class);
        if (($result = $stmt->fetch()) === false) {
            throw new EntityNotFoundException();
        }
        return $result;
    }
}
