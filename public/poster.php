<?php

// Albin BLACHON

declare(strict_types=1);

use Entity\Poster;
use Exception\EntityNotFoundException;
use Exception\ParameterException;

try {
    // if posterId is an int
    if (isset($_GET['posterId']) && ctype_digit($_GET['posterId'])) {
        // get the poster
        $posterId = intval($_GET['posterId']);
        $poster = Poster::findById($posterId);
        // return the poster image
        header('Content-Type: image/jpeg');
        if ($poster->getJpeg() === false) {
            echo "img/default_poster.jpeg";
        } else {
            echo $poster->getJpeg();
        }
        // if posterId not define or not an int throw an exception
    } else {
        throw new ParameterException('');
    }
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}
