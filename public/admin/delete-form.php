<?php

declare(strict_types=1);

use Entity\Game;
use Exception\EntityNotFoundException;
use Exception\ParameterException;
use Entity\Genre;
use Entity\Category;

try {
    if (!empty($_GET["gameId"]) && ctype_digit($_GET["gameId"])) {
        $game = Game::findById(intval($_GET["gameId"]));
        // Delete all association between the game and all his genres
        $genres = $game->getAssignedGenres();
        foreach ($genres as $genre) {
            $game->removeGenre($genre->getId());
        }
        // Delete all association between the game and all his categories
        $categories = $game->getAssignedCategories();
        foreach ($categories as $category) {
            $game->removeCategory($category->getId());
        }
        $game->delete();
    } else {
        throw new ParameterException();
    }
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
header("Location: /");
