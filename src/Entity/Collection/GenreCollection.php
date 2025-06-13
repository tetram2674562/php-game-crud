<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Genre;
use Exception\EntityNotFoundException;
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

    /** Select all genres of a game from the gameId
     *
     * @param int $id The game id
     * @return Genre[] The genre list.
     * @throws EntityNotFoundException If no genre founded.
     */
    public static function getGenresFromGameId(int $id): array
    {
        // prepare request
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT *
            FROM genre
            WHERE id IN (SELECT genreId
                         FROM game_genre ge 
                            INNER JOIN game ga ON (ge.gameId = ga.id)
                         WHERE ga.id = :id)
            SQL
        );
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        // fetch response
        $stmt->setFetchMode(PDO::FETCH_CLASS, Genre::class);
        // if no genre founded
        if(($resp = $stmt->fetchAll()) === false){
            throw new EntityNotFoundException();
        }
        return $resp;
    }
}
