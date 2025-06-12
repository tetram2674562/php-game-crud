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
    $appWebPage->appendContent("<div class='__content'>");
    // For each games
    foreach ($games as $game) {
        $appWebPage->appendContent(
            <<<HTML
                    
                        <a class='detail' href="game.php?gameId={$game->getId()}">
                            <img src="poster.php?posterId={$game->getPosterId()}" alt="{$appWebPage->escapeString($game->getName())}">
                            <div>
                                <h3>{$appWebPage->escapeString($game->getName())} ({$game->getReleaseYear()})</h3>
                                <p>{$appWebPage->escapeString($game->getShortDescription())}</p>
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
