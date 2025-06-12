<?php

declare(strict_types=1);

use Entity\Collection\CategoryCollection;
use Entity\Collection\GenreCollection;
use Html\AppWebPage;

// creation of the webpage
$appWebPage = new AppWebPage("Jeux vidéos");
// Creation of categories

// Creation of genres
$appWebPage->appendContent("<div class='genres'>\n");
// creation of the subtitle for genres
$appWebPage->appendContent("<h2 >Genres</h2>\n");
foreach (GenreCollection::findAll() as $genre) {
    $appWebPage->appendContent("<a href='genre.php?genreId={$genre->getId()}'>{$genre->getDescription()}</a>\n");
}
$appWebPage->appendContent("</div>");
$appWebPage->appendContent("<div class='categories'>\n");
// creation of the subtitle for category
$appWebPage->appendContent("<h2>Catégories</h2>\n");
foreach (CategoryCollection::findAll() as $category) {
    $appWebPage->appendContent("<a href='category.php?categoryId={$category->getId()}' class='category'>{$category->getDescription()}</a>\n");
}
// Creation of genres
$appWebPage->appendContent("</div>\n\t\t\t<div class='genres'>\n");
// creation of the subtitle for genre
$appWebPage->appendContent("<h2 class='subtitle'>Genre</h2>\n");
foreach (GenreCollection::findAll() as $genre) {
    $appWebPage->appendContent("<a href='genre.php?genreId={$genre->getId()}' class='genre'>{$genre->getDescription()}</a>\n");
}
// Closing every the box
$appWebPage->appendContent("</div>");
echo $appWebPage->toHTML();
