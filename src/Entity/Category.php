<?php
// Albin Blachon  

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Exception\EntityNotFoundException;
use PDO;

class Category
{
    private int $id;
    private string $desc;

    /** Search the category by an Id.
     *
     * @param int $id The category id.
     * @return Category The category found
     * @throws EntityNotFoundException If no Category was find from the id.
     */
    public static function findById(int $id): Category
    {
        // request prepare
        $request = MyPdo::getInstance()->prepare(<<<SQL
            SELECT * 
            FROM game_category
            WHERE gameId = :id
            SQL
        );
        $request->bindValue(':id', $id);
        $request->setFetchMode(PDO::FETCH_CLASS, Category::class);
        // if the request find no category generate an exception
        if (($response = $request->fetch()) === false) {
            throw new EntityNotFoundException();
        }
        return $response;
    }
}