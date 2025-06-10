<?php

// Albin Blachon

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Category;
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
            SELECT * 
            FROM game_category
            SQL
        );
        $request->execute();
        $request->setFetchMode(PDO::FETCH_CLASS, Category::class);
        return $request->fetchAll();
    }
}
