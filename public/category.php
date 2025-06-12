<?php

declare(strict_types=1);

use Entity\Category;
use Entity\Collection\GameCollection;
use Exception\EntityNotFoundException;
use Exception\ParameterException;
use Html\AppWebPage;

try {
    if (empty($_GET["categoryId"]) || !ctype_digit($_GET["categoryId"])) {
        throw new ParameterException();
    }
    // Find the category
    $category = Category::findById(intval($_GET["categoryId"]));
    // Create the new page
    $appWebPage = new AppWebPage("Jeux Vidéo : {$category->getDescription()}");
    // Get all the game for this category
    $games = GameCollection::findGameByCategoryId($category->getId());
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
