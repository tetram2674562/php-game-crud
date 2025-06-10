<?php
// Albin Blachon  

declare(strict_types=1);

namespace Entity;

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

}