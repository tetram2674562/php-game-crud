<?php

declare(strict_types=1);

use Entity\Game;
use Exception\EntityNotFoundException;
use Exception\ParameterException;
use Html\Form\GameForm;

try {
    $game = null;
    if (isset($_GET["gameId"]) && ctype_digit($_GET["gameId"])) {
        $game = Game::findById(intval($_GET["gameId"]));

    }
    $gameForm = new GameForm($game);
    echo $gameForm->toHTML("game-save.php");
} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}
