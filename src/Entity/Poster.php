<?php

// Albin Blachon

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Exception\EntityNotFoundException;
use PDO;

class Poster
{
    private int $id;
    private string $jpeg;

    /**
     * @return string The jpeg data.
     */
    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    /**
     * @return int The id.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** Search the poster by his id.
     *
     * @param int $id The poster id.
     * @return Poster The poster.
     * @throws EntityNotFoundException If no Poster was found.
     */
    public static function findById(int $id): Poster
    {

        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT *
            FROM poster
            WHERE id = :id
            SQL
        );
        $stmt->bindValue(':id', $id);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Poster::class);
        $stmt-> execute();
        if (($resp = $stmt->fetch()) === false) {
            throw new EntityNotFoundException();
        }
        return $resp;
    }

    /** Constructor of Poster class.
     *
     * @param string $jpeg The url of the poster.
     * @param int|null $id The id of the poster. It can be null or an int.
     * @return void
     */
    private function __constructor(string $jpeg, ?int $id)
    {
        $this->id = $id;
        $this->jpeg = $jpeg;
    }
    /** Create a new Poster.
     *
     * @param string $jpeg The url of the poster.
     * @param int|null $id The id of poster. By default, this is null.
     * @return Poster The poster created.
     */
    public static function create(string $jpeg, ?int $id = null): Poster
    {
        return new Poster($jpeg, $id);
    }

    /** Insert the poster into the database.
     * Set the id of the current instance.
     *
     * @return $this The current instance.
     */
    public function insert(): Poster
    {
        // Insert the poster into the database
        $addDataBase = MyPdo::getInstance()->prepare(
            <<<SQL
            INSERT INTO poster (jpeg)
            VALUES (:jpeg)
            SQL
        );
        $addDataBase->bindValue(":jpeg", $this->getJpeg());
        $addDataBase->execute();

        // Set the instance id
        $id = MyPdo::getInstance()->lastInsertId("id");
        $this->id = intval($id);

        return $this;
    }
}
