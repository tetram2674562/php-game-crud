<?php

declare(strict_types=1);

use Exception\EntityNotFoundException;
use Exception\ParameterException;
use Html\Form\GameForm;

try {
    $gameForm = new GameForm();
    echo $gameForm->toHTML("game-save.php");
} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}