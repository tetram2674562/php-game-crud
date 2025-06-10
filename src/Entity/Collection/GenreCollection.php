<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Genre;
use PDO;

class GenreCollection
{
    /** Find every instance of Genre in the database.
     *
     * @return Genre[] All the genre presents in the database.
     */
    public static function findAll(): array
    {
        // Get all genre from the genre table
        $stmt = MyPdo::getInstance()->prepare(<<< 'SQL'
            SELECT id,description
            FROM genre
        SQL);
        // Set the fetch mode
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, Genre::class);
        return $stmt->fetchAll();
    }
}
