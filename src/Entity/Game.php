<?php

// Albin Blachon

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Exception\EntityNotFoundException;
use PDO;

class Game
{
    private int $id;
    private string $name;
    private int $releaseYear;
    private string $shortDescription;
    private int $price;
    private int $windows;
    private int $linux;
    private int $mac;
    private int $metacritic;
    private int $developerId;
    private int $posterId;

    /** Find a game by an Id.
     *
     * @param int $id Game id.
     * @return Game The game found.
     * @throws EntityNotFoundException If no game was found for the Id.
     */
    public static function findById(int $id): Game
    {
        // Prepare request
        $request = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT *
            FROM game
            WHERE id = :gameId
            SQL
        );
        $request->bindValue(":gameId", $id);
        // Execute request
        $request->execute();
        $request->setFetchMode(PDO::FETCH_CLASS, Game::class);
        // If there is no game for the id, throw an exception
        if (($response = $request->fetch()) === false) {
            throw new EntityNotFoundException();
        }
        return $response;
    }
}
