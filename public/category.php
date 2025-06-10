<?php

declare(strict_types=1);

use Exception\EntityNotFoundException;
use Exception\ParameterException;
use Html\AppWebPage;

try {
    if (!isset($_GET["categoryId"]) || empty($_GET["categoryId"])) {
        throw new ParameterException();
    }

    $appWebPage = new AppWebPage("Jeux Vidéo : {}");

} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}
