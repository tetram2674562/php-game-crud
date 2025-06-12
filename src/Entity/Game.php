<?php

// Albin Blachon

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Exception\EntityNotFoundException;
use PDO;

class Game
{
    private ?int $id;
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

    private function __construct()
    {
    }

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

    public static function create(string $name, int $releaseYear, string $shortDescription, int $price, int $windows, int $macos, int $linux, int $posterId, ?int $developerId = null, ?int $id = null, ?int $metacritic = null): Game
    {
        $game = new Game();
        $game->setName($name);
        $game->setReleaseYear($releaseYear);
        $game->setShortDescription($shortDescription);
        $game->setPrice($price);
        $game->setLinux($linux);
        $game->setMac($macos);
        $game->setWindows($windows);
        $game->setPosterId($posterId);
        $game->setDeveloperId($developerId);
        $game->setId($id);
        $game->setMetacritic($metacritic);
        return $game;
    }

    /** Get the name of the game
     *
     * @return string The name of the game
     */
    public function getName(): string
    {
        return $this->name;
    }

    /** Set the name of the game
     *
     * @param string $name The name of the game
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /** Get the game release date (year)
     *
     * @return int The game release date (year)
     */
    public function getReleaseYear(): int
    {
        return $this->releaseYear;
    }

    /** Set the year of release of the game
     *
     * @param int $releaseYear The year of release
     * @return void
     */
    public function setReleaseYear(int $releaseYear): void
    {
        $this->releaseYear = $releaseYear;
    }

    /** Get a short description of the game
     *
     * @return string A short description of the game
     */
    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    /** Set the short description of the game
     *
     * @param string $shortDescription The short description of the game
     * @return void
     */
    public function setShortDescription(string $shortDescription): void
    {
        $this->shortDescription = $shortDescription;
    }

    /** Get the price of the game
     *
     * @return int The price of the game
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /** Set the price of the game
     *
     * @param int $price The price of the game
     * @return void
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /** Get if the game is available on windows : 1 if yes 0 if no
     *
     * @return int if the game is available on windows
     */
    public function getWindows(): int
    {
        return $this->windows;
    }

    /** Set if the game is on windows
     *
     * @param int $windows 0 if It isn't and 1 if It is.
     * @return void
     */
    public function setWindows(int $windows): void
    {
        $this->windows = $windows;
    }

    /** Get if the game is available on linux : 1 if yes 0 if no
     *
     * @return int if the game is available on linux
     */
    public function getLinux(): int
    {
        return $this->linux;
    }

    /** Set if the game is on linux
     *
     * @param int $linux 0 if It isn't and 1 if It is.
     * @return void
     */
    public function setLinux(int $linux): void
    {
        $this->linux = $linux;
    }

    /** Get if the game is available on macOS : 1 if yes 0 if no
     *
     * @return int if the game is available on macOS
     */
    public function getMac(): int
    {
        return $this->mac;
    }

    /** Set if the game is on macos
     *
     * @param int $mac 0 if It isn't and 1 if It is.
     * @return void
     */
    public function setMac(int $mac): void
    {
        $this->mac = $mac;
    }

    /** Get the metacritic score of the game
     *
     * @return ?int the metracritic score of the game (or null if no metacritic score is associated with the game)
     */
    public function getMetacritic(): ?int
    {
        return $this->metacritic;
    }

    /** Set the metacritic score.
     *
     * @param int|null $metacritic The metacritic score of the game.
     * @return void
     */
    public function setMetacritic(?int $metacritic): void
    {
        $this->metacritic = $metacritic;
    }

    /** Get the developer id of the game
     *
     * @return ?int get the developer id of the game (or null if no developer is associated with the game)
     */
    public function getDeveloperId(): ?int
    {
        return $this->developerId;
    }

    /** Set the developer id of the game.
     *
     * @param int|null $developerId The developer id or null if there isn't a developer on the game
     * @return void
     */
    public function setDeveloperId(?int $developerId): void
    {
        $this->developerId = $developerId;
    }

    /** Get the poster id of the game
     *
     * @return int The poster id of the game
     */
    public function getPosterId(): int
    {
        return $this->posterId;
    }

    /** Set the posterId of the game
     *
     * @param int $posterId The poster id
     * @return void
     */
    public function setPosterId(int $posterId): void
    {
        $this->posterId = $posterId;
    }

    /** Delete the game from the database.
     *
     * @return $this The instance of this game.
     */
    public function delete(): Game
    {

        // Delete request
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
        DELETE FROM game
        WHERE id = :id
        SQL
        );
        // bind parameter id to the current id
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        // Set the current id to null
        $this->id = null;
        return $this;
    }

    /**
     * Save the data of the game inside the database
     * @return void
     */
    public function save(): void
    {
        if ($this->getId() == null) {
            $this->insert();
        } else {
            $this->update();
        }
    }

    /** Get the id of the game
     *
     * @return int id of the game
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** Set the id of the game
     *
     * @param int|null $id The id of the game or null if It isn't present in the database.
     * @return void
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /** Insert the current game into the database
     *
     * @return $this The game
     */
    public function insert() : Game
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<< 'SQL'
                INSERT INTO game(name,
                                   releaseYear,
                                   shortDescription,
                                   price,
                                   windows,
                                   linux,
                                   mac,
                                   metacritic,
                                   developerId,
                                   posterId) 
                VALUES (:name,
                        :releaseYear,
                        :shortDescription,
                        :price,
                        :windows,
                        :mac,
                        :linux,
                        :metacritic,
                        :developerId,
                        :posterId)
            SQL
        );
        // bind param for all field
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":releaseYear", $this->releaseYear);
        $stmt->bindParam(":shortDescription", $this->shortDescription);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":windows", $this->windows);
        $stmt->bindParam(":mac", $this->mac);
        $stmt->bindParam(":linux", $this->linux);
        $stmt->bindParam(":metacritic", $this->metacritic);
        $stmt->bindParam(":developerId", $this->developerId);
        $stmt->bindParam(":posterId", $this->posterId);
        $stmt->execute();
        // set id to the defined id (autoincrement by the database)
        $this->setId(intval(MyPdo::getInstance()->lastInsertId()));

        return $this;
    }

    /** Update all information of the game into the database.
     *
     * @return $this The game
     */
    public function update() : Game
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<< 'SQL'
                UPDATE game
                SET name = :name
                SET releaseYear = :releaseYear
                SET shortDescription = :shortDescription
                SET price = :price
                SET windows = :windows
                SET mac = :mac
                SET linux = :linux
                SET metacritic = :metacritic
                SET developerId = :developerId
                SET posterId = :posterId
                WHERE id = :id
            SQL
        );
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":releaseYear", $this->releaseYear);
        $stmt->bindParam(":shortDescription", $this->shortDescription);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":windows", $this->windows);
        $stmt->bindParam(":mac", $this->mac);
        $stmt->bindParam(":linux", $this->linux);
        $stmt->bindParam(":metacritic", $this->metacritic);
        $stmt->bindParam(":developerId", $this->developerId);
        $stmt->bindParam(":posterId", $this->posterId);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $this;
    }
}
