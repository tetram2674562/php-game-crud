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
    $appWebPage->appendContent("\n\t\t\t</div>");

    // Créer le menu

    $menu = <<<HTML
        <a id="home_button" href="index.php">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
            <path fill="#78899b" d="M575.8 255.5c0 18-15 32.1-32 32.1l-32 0 .7 160.2c0 2.7-.2 5.4-.5 8.1l0 16.2c0 22.1-17.9 40-40 40l-16 0c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1L416 512l-24 0c-22.1 0-40-17.9-40-40l0-24 0-64c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32 14.3-32 32l0 64 0 24c0 22.1-17.9 40-40 40l-24 0-31.9 0c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2l-16 0c-22.1 0-40-17.9-40-40l0-112c0-.9 0-1.9 .1-2.8l0-69.7-32 0c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/></svg>
        </a>
        <a id="add_button" href="admin/game-form.php">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path fill="#78899b" d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 144L48 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l144 0 0 144c0 17.7 14.3 32 32 32s32-14.3 32-32l0-144 144 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-144 0 0-144z"/>
            </svg>
        </a>
        HTML;

    $appWebPage->addContentMenu($menu);


    echo $appWebPage->toHTML();
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (ParameterException) {
    http_response_code(400);
} catch (Exception) {
    http_response_code(500);
}
