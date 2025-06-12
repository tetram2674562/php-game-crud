<?php

declare(strict_types=1);

use Entity\Collection\CategoryCollection;
use Entity\Collection\GenreCollection;
use Html\AppWebPage;

// creation of the webpage
$appWebPage = new AppWebPage("Jeux vidéos");

// Creation of the div index-content
$appWebPage->appendContent("<div class='index-content'>\n");
// Creation of categories
$appWebPage->appendContent("\t\t\t\t<div class='categories'>\n");
// creation of the subtitle for category
$appWebPage->appendContent("\t\t\t\t\t<h2>Catégories</h2>\n");
foreach (CategoryCollection::findAll() as $category) {
    $appWebPage->appendContent("\t\t\t\t\t<a href='category.php?categoryId={$category->getId()}'>{$category->getDescription()}</a>\n");
}
// Creation of genres
$appWebPage->appendContent("\t\t\t\t</div>\n\t\t\t\t<div class='genres'>\n");
// creation of the subtitle for genre
$appWebPage->appendContent("\t\t\t\t\t<h2>Genre</h2>\n");
foreach (GenreCollection::findAll() as $genre) {
    $appWebPage->appendContent("\t\t\t\t\t<a href='genre.php?genreId={$genre->getId()}' >{$genre->getDescription()}</a>\n");
}
// Closing every the box
$appWebPage->appendContent("\t\t\t\t</div>\n\t\t\t</div>");
echo $appWebPage->toHTML();
