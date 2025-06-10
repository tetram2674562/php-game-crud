<?php
// Albin Blachon  

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
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
    public static function findGameByCollectionId(int $categoryId): array
    {
        $stmt = MyPdo::getInstance()->prepare(<<<SQL
            SELECT * 
            FROM game g 
                INNER JOIN game_category c ON (c.gameId = g.id)
            WHERE c.categoryId = :categoryId
            SQL
        );
        $stmt->bindValue(':categoryId', $categoryId);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Game::class);
        $stmt->execute();
        if (($resp = $stmt->fetchAll()) === false) {
            throw new EntityNotFoundException();
        }
        return $resp;

    }
}
}