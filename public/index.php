<?php

declare(strict_types=1);

use Entity\Collection\CategoryCollection;
use Entity\Collection\GenreCollection;
use Html\AppWebPage;

// creation of the webpage
$appWebPage = new AppWebPage("Jeux vidéos");
// creation of the title
$appWebPage->appendContent("<h2 class='subtitle'>Catégorie</h2>");
$appWebPage->appendContent("<h2 class='subtitle'>Genre</h2>");
// Creation of categories
$appWebPage->appendContent("<div class='categories'>");
foreach (CategoryCollection::findAll() as $category) {
    $appWebPage->appendContent("<a href='' class='category'></a>");
}
// Creation of genres
$appWebPage->appendContent("</div>\n\t\t\t<div class='genres'>");
foreach (GenreCollection::findAll() as $genre) {
    $appWebPage->appendContent("<a href='' class='genre'></a>");
}
// Closing every the box
$appWebPage->appendContent("</div>");
