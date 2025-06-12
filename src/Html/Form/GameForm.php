<?php

declare(strict_types=1);

namespace Html\Form;

use Entity\Game;
use Html\StringEscaper;

class GameForm
{
    use StringEscaper;

    private ?Game $game;

    /** Create a new form
     *
     * @param Game|null $game A game (or null if there is no game).
     */
    public function __construct(?Game $game = null)
    {
        $this->game = $game;
    }

    /** Get the game of this form
     *
     * @return ?Game The game
     */
    public function getGame(): ?Game
    {
        return $this->game;
    }

}
