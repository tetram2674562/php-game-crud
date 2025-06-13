<?php

declare(strict_types=1);

use Exception\EntityNotFoundException;
use Exception\ParameterException;
use Html\Form\GameForm;

try {
    $form = new GameForm();
    $form->saveGameFromQueryString();
    header("Location: /");
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}
header("Location: /");