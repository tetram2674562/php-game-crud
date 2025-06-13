<?php

declare(strict_types=1);

namespace Html\Form;

use Entity\Collection\CategoryCollection;
use Entity\Collection\DeveloperCollection;
use Entity\Collection\GenreCollection;
use Entity\Developer;
use Entity\Game;
use Exception\EntityNotFoundException;
use Html\StringEscaper;

class GameForm
{
    use StringEscaper;

    private ?Game $game;

    /** Create a new form
     *
     * @param Game|null $game A game (or null if there is no game).
     */
    public function __construct(?Game $game = null)
    {
        $this->game = $game;
    }

    /** Get the game of this form
     *
     * @return ?Game The game
     */
    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function toHTML(string $action): string
    {
        $developer = null;
        try {
            if (($devID = $this->getGame()?->getDeveloperId()) != null) {
                $developer = Developer::findById($devID);
            }
        } catch (EntityNotFoundException) {

        }


        $form = <<< HTML
        <!doctype html>
        <html lang="fr">
        <head>
        <meta charset="UTF-8">
                     <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                                 <meta http-equiv="X-UA-Compatible" content="ie=edge">
                     <title>Formulaire pour l'ajout de jeux vidéo</title>
                     <link rel="stylesheet" href="/css/style.css" >
        </head>
        <body>
            <h1>Formulaire de modification de la base de données</h1>
            <form action="{$action}" method="post" class="form">
                <input type="hidden" name="id" id="id" value="{$this?->getGame()?->getId()}">
               
                <label for="name">
                    Nom <input type="text" name="name" id="name" value="{$this->escapeString($this?->getGame()?->getName())}" required> <br>
                </label>
                <label for="releaseYear">
                    Date de sortie <input type="text" name="releaseYear" id="releaseYear" value="{$this->escapeString($this->getGame()?->getReleaseYear())}" required><br>
                </label>
                <label for="shortDescription">
                    Description courte <input type="text" name="shortDescription" id="shortDescription" value="{$this->escapeString($this?->getGame()?->getShortDescription())}" required><br>
                </label>
                <label for="price">
                    Prix <input type="number" name="price" id="price" value="{$this->escapeString($this?->getGame()?->getPrice())}" required><br>
                </label>
                <label for="windows">
                    Windows <input type="text" name="windows" id="windows" value="{$this->escapeString($this?->getGame()?->getWindows())}" required><br>
                </label>
                <label for="linux">
                    Linux <input type="text" name="linux" id="linux" value="{$this->escapeString($this?->getGame()?->getLinux())}" required><br>
                </label>
                <label for="mac">
                    MacOS <input type="text" name="mac" id="mac" value="{$this->escapeString($this?->getGame()?->getMac())}" required><br>
                </label>
                <label for="metacritic">
                    Score metacritic <input type="number" name="metacritic" id="metacritic" value="{$this->escapeString($this->getGame()?->getMetacritic())}" required><br>
                </label>
                <!-- Add a new poster so It's a file input -->
                <label for="poster">
                    Poster <input type="file" name="poster" id="poster" value="" accept="image/jpeg"><br>
                </label>
        HTML;
        $selected = $developer == null ? "selected='selected'" : "";
        $form .= "\t\t\tDeveloper <select name='developer'>\n\t\t\t\t<option value='' {$selected}></option>";
        foreach (DeveloperCollection::findAll() as $developers) {
            $selected = $developer?->getName() == $developers->getName() ? "selected='selected'" : "";
            $form .= "\t\t\t\t<option value='{$this->escapeString($developers->getName())}' {$selected}>{$this->escapeString($developers->getName())}</option>\n";
        }

        $form .= "\t\t\t</select>\n\t\t\t<div class='categories_select'>Categories";
        foreach (CategoryCollection::findAll() as $category) {
            $form.= <<< HTML
                    <label>
                        <input type="checkbox" name="categories[]" value="{$this->escapeString($category->getDescription())}"> {$this->escapeString($category->getDescription())}
                    </label>
            HTML;
        }
        $form .= "\t\t\t</div>\n\t\t\t<div class='genres_select'>Genres";
        foreach (GenreCollection::findAll() as $genre) {
            $form.= <<< HTML
                    <label>
                        <input type="checkbox" name="genres[]" value="{$this->escapeString($genre->getDescription())}"> {$this->escapeString($genre->getDescription())}
                    </label>
            HTML;
        }
        $form .= "\t\t\t</div>";
        $form .= <<<HTML
                <input type="submit" value="Enregistrer">
            </form>  
        </body>
        </html>
        HTML;

        return $form;
    }
}
