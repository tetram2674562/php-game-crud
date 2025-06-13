<?php

// Albin Blachon

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Exception\EntityNotFoundException;
use PDO;

class Poster
{
    private ?int $id;
    private string $jpeg;

    /**
     * @return string The jpeg data.
     */
    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    /**
     * @return ?int The id.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $jpeg
     */
    public function setJpeg(string $jpeg): void
    {
        $this->jpeg = $jpeg;
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

    /** Constructor is null because it lead the code to some errors.
     *
     */
    private function __construct()
    {

    }

    /** Create a new Poster.
     * Use an empty constructor and setters to set attributes.
     *
     * @param string $jpeg The url of the poster.
     * @param int|null $id The id of poster. By default, this is null.
     * @return Poster The poster created.
     */
    public static function create(string $jpeg, ?int $id = null): Poster
    {
        $poster = new Poster();
        $poster->setId($id);
        $poster->setJpeg($jpeg);

        return $poster;
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

    /** Update the poster in the database.
     * Set the jpeg with the current instance jpeg.
     *
     * @return $this The current instance.
     */
    public function update(): Poster
    {
        // Update the poster in the database
        $updateDataBase = MyPdo::getInstance()->prepare(
            <<<SQL
            UPDATE poster
            SET jpeg = :jpeg
            WHERE id = :id
            SQL
        );
        $updateDataBase->bindValue(":jpeg", $this->getJpeg());
        $updateDataBase->bindValue(":id", $this->getId());
        $updateDataBase->execute();

        return $this;
    }

    /** Choose between the insert or update method.
     * If id is null, we choose to insert the poster, else we choose to update the poster.
     *
     * @return $this The current instance
     */
    public function save(): Poster
    {
        // If id is null
        if ($this->getId() === null) {
            // Then insert
            $this->insert();
        } else {
            // Else update
            $this->update();
        }

        return $this;
    }

    /** Delete the current poster in the database.
     * Set the current instance id as null.
     *
     * @return $this The current instance
     */
    public function delete(): Poster
    {
        // Delete the database line.
        $deletePoster = MyPdo::getInstance()->prepare(
            <<<SQL
            DELETE 
            FROM poster
            WHERE id = :id
            SQL
        );
        $id = $this->getId();
        $deletePoster->bindParam(":id", $id);
        $deletePoster->execute();
        //set the current id as null
        $this->id = null;

        return $this;
    }
}
