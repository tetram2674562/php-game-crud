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
    private ?int $metacritic;
    private ?int $developerId;
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

    /** Get the id of the game
     *
     * @return int id of the game
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** Get the name of the game
     *
     * @return string The name of the game
     */
    public function getName(): string
    {
        return $this->name;
    }

    /** Get the game release date (year)
     *
     * @return int The game release date (year)
     */
    public function getReleaseYear(): int
    {
        return $this->releaseYear;
    }

    /** Get a short description of the game
     *
     * @return string A short description of the game
     */
    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    /** Get the price of the game
     *
     * @return int The price of the game
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /** Get if the game is available on windows : 1 if yes 0 if no
     *
     * @return int if the game is available on windows
     */
    public function getWindows(): int
    {
        return $this->windows;
    }


    /** Get if the game is available on linux : 1 if yes 0 if no
     *
     * @return int if the game is available on linux
     */
    public function getLinux(): int
    {
        return $this->linux;
    }


    /** Get if the game is available on macOS : 1 if yes 0 if no
     *
     * @return int if the game is available on macOS
     */
    public function getMac(): int
    {
        return $this->mac;
    }


    /** Get the metacritic score of the game
     *
     * @return int the metracritic score of the game
     */
    public function getMetacritic(): ?int
    {
        return $this->metacritic;
    }


    /** Get the developer id of the game
     *
     * @return int get the developer id of the game
     */
    public function getDeveloperId(): ?int
    {
        return $this->developerId;
    }

    /** Get the poster id of the game
     *
     * @return int The poster id of the game
     */
    public function getPosterId(): int
    {
        return $this->posterId;
    }
}
