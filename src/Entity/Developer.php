<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Exception\EntityNotFoundException;
use PDO;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

class Developer
{
    private int $id;
    private string $name;

    /** Get id of the developer
     *
     * @return int The id of the developer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** The name of the developer
     *
     * @return string The name of the developer
     */
    public function getName(): string
    {
        return $this->name;
    }

    /** Get a new instance of developer by his id
     *
     * @param int $id The id of the developer
     * @return Developer The developer itself.
     * @throws EntityNotFoundException Thrown if no developer was found with this id.
     */
    public static function findById(int $id): Developer
    {
        // Prepare request
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT *
            FROM developer
            WHERE id = :devId
            SQL
        );
        $stmt->bindValue(":devId", $id);
        // Execute request
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, Developer::class);
        // if no developer was found with this id
        if (($response = $stmt->fetch()) === false) {
            // throw an exception
            throw new EntityNotFoundException();
        }
        return $response;
    }
}
