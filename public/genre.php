<?php

declare(strict_types=1);

use Entity\Category;
use Entity\Collection\GameCollection;
use Entity\Genre;
use Exception\EntityNotFoundException;
use Exception\ParameterException;
use Html\AppWebPage;

try {
    if (empty($_GET["genreId"]) || !ctype_digit($_GET["genreId"])) {
        throw new ParameterException();
    }
    // Find the genre
    $genre = Genre::findById(intval($_GET["genreId"]));
    // Create the new page
    $appWebPage = new AppWebPage("Jeux Vidéo : {$genre->getDescription()}");
    // Get all the game for this genre
    $games = GameCollection::findGameByGenreId($genre->getId());
    // For each games
    foreach ($games as $game) {
        $appWebPage->appendContent(
            <<<HTML
        <a href="game.php?gameId={$game->getId()}">
            <img src="poster.php?posterId={$game->getPosterId()}" alt="{$game->getName()}">
            <div>
                <p>{$game->getName()} ({$game->getReleaseYear()})</p>
                <p>{$game->getShortDescription()}</p>
            </div>
        </a>
        HTML
        );
    }
    echo $appWebPage->toHTML();
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}
