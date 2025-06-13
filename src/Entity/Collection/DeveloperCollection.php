<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Developer;
use PDO;

class DeveloperCollection
{
    /** Find every instance of Genre in the database.
     *
     * @return Developer[] All the genre presents in the database.
     */
    public static function findAll(): array
    {
        // Get all genre from the genre table
        $stmt = MyPdo::getInstance()->prepare(<<< 'SQL'
            SELECT *
            FROM developer
        SQL);
        // Set the fetch mode
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, Developer::class);
        return $stmt->fetchAll();
    }
}