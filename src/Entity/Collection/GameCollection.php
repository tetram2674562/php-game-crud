<?php

// Albin Blachon

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Game;
use Exception\EntityNotFoundException;
use PDO;

class GameCollection
{
    /** Search every game associate to a collection.
     *
     * @param int $categoryId The category id.
     * @return Game[] The game list
     * @throws EntityNotFoundException If there is no result.
     */
    public static function findGameByCategoryId(int $categoryId, int $sort = 0): array
    {
        $querry = <<<SQL
            SELECT * 
            FROM game g 
                INNER JOIN game_category c ON (c.gameId = g.id)
            WHERE c.categoryId = :categoryId
            SQL;
        if ($sort === 1) {
            $querry .= "\nORDER BY name";
        } elseif ($sort === 2) {
            $querry .= "\nORDER BY releaseYear";
        }
        $stmt = MyPdo::getInstance()->prepare($querry);
        $stmt->bindValue(':categoryId', $categoryId);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Game::class);
        $stmt->execute();
        if (($resp = $stmt->fetchAll()) === false) {
            throw new EntityNotFoundException();
        }
        return $resp;
    }

    /** Search every games of a genre.
     *
     * @param int $genreId Genre Id.
     * @return Game[] The list of games
     * @throws EntityNotFoundException If no game is found.
     */
    public static function findGameByGenreId(int $genreId, int $sort = 0): array
    {
        $querry =   <<<SQL
            SELECT * 
            FROM game g 
                INNER JOIN game_genre c ON (c.gameId = g.id)
            WHERE c.genreId = :genreId
            SQL;


        if ($sort === 1) {
            $querry .= "\nORDER BY name";
        } elseif ($sort === 2) {
            $querry .= "\nORDER BY releaseYear";
        }
        $stmt = MyPdo::getInstance()->prepare($querry);
        $stmt->bindValue(':genreId', $genreId);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Game::class);
        $stmt->execute();
        if (($resp = $stmt->fetchAll()) === false) {
            throw new EntityNotFoundException();
        }
        return $resp;
    }
}
