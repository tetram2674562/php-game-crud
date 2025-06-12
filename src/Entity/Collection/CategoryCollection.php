<?php

// Albin Blachon

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Category;
use Exception\EntityNotFoundException;
use PDO;

class CategoryCollection
{
    /** Get every category of the table game_category
     *
     * @return Category[] All categories
     */
    public static function findAll(): array
    {
        $request = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT id,description 
            FROM category;
            SQL
        );
        $request->execute();
        $request->setFetchMode(PDO::FETCH_CLASS, Category::class);
        return $request->fetchAll();
    }

    /** Select all categories of a game by the game id/
     *
     * @param int $id The game id.
     * @return Category[] The list of category
     * @throws EntityNotFoundException If no category founded.
     */
    public function getCategoriesFromGameId(int $id): array
    {
        // prepare request
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT *
            FROM category
            WHERE id IN (SELECT categoryId
                         FROM game_category c 
                            INNER JOIN game g ON (c.gameId = g.id)
                         WHERE g.id = :id)
             SQL
        );
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        // fetch response
        $stmt->setFetchMode(PDO::FETCH_CLASS, Category::class);
        // if no category founded
        if(($resp = $stmt->fetchAll()) === false){
            throw new EntityNotFoundException();
        }
        return $resp;
    }
}
