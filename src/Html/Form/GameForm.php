<?php

declare(strict_types=1);

namespace Html\Form;

use Entity\Category;
use Entity\Collection\CategoryCollection;
use Entity\Collection\DeveloperCollection;
use Entity\Collection\GenreCollection;
use Entity\Developer;
use Entity\Game;
use Entity\Genre;
use Entity\Poster;
use Exception\EntityNotFoundException;
use Exception\ParameterException;
use Html\StringEscaper;

class GameForm
{
    use StringEscaper;

    private ?Game $game;
    private ?string $posterData;
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

    /** Produce the output HTML of the form.
     *
     * @param string $action The page to send data to
     * @return string The HTML
     */
    public function toHTML(string $action): string
    {
        $developer = null;
        try {
            if (($devID = $this->getGame()?->getDeveloperId()) != null) {
                $developer = Developer::findById($devID);
            }
        } catch (EntityNotFoundException) {

        }

        // We map the whole lists of genres and categories to get their names.
        if ($this->getGame() != null) {
            $genres = array_map(function (Genre $genre) {
                return $genre->getDescription();
            }, $this->getGame()?->getAssignedGenres());
            $categories = array_map(function (Category $cat) {
                return $cat->getDescription();
            }, $this->getGame()?->getAssignedCategories());
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
                <input type="hidden" name="id" id="id" value="{$this->getGame()?->getId()}">
                <input type="hidden" name="posterId" id="posterId" value="{$this->getGame()?->getPosterId()}">
                <label for="name">
                    Nom <input type="text" name="name" id="name" value="{$this->escapeString($this?->getGame()?->getName())}" required> <br>
                </label>
                <label for="releaseYear">
                    Date de sortie <input type="text" name="releaseYear" id="releaseYear" value="{$this->escapeString(strval($this->getGame()?->getReleaseYear()))}" required><br>
                </label>
                <label for="shortDescription">
                    Description courte <input type="text" name="shortDescription" id="shortDescription" value="{$this->escapeString($this?->getGame()?->getShortDescription())}" required><br>
                </label>
                <label for="price">
                    Prix (en centimes) <input type="number" name="price" min="0" id="price" value="{$this?->getGame()?->getPrice()}" required> €<br>
                </label>
                
                <label for="metacritic">
                    Score metacritic <input type="number" min="0" max="100" name="metacritic" id="metacritic" value="{$this->getGame()?->getMetacritic()}" required><br>
                </label>
                <!-- Add a new poster so It's a file input -->
                <label for="poster">
                    Poster <input type="file" name="poster" id="poster" value="" accept="image/jpeg"><br>
                </label>
        HTML;
        $windows = $this->getGame()?->getWindows() == 0 ? ["selected='selected'",""] : ["","selected='selected'"];
        $linux = $this->getGame()?->getLinux() == 0 ? ["selected='selected'",""] : ["","selected='selected'"];
        $mac = $this->getGame()?->getMac() == 0 ? ["selected='selected'",""] : ["","selected='selected'"];
        $form .= <<<HTML
                <label for="windows">
                    Windows <select name="windows" id="windows">
                        <option value="0" $windows[0]>Incompatible</option>
                        <option value="1" $windows[1]>Compatible</option>
                    </select>
                </label><br>
        HTML;
        $form .= <<<HTML
                <label for="linux">
                    Linux <select name="linux" id="linux">
                        <option value="0" $linux[0]>Incompatible</option>
                        <option value="1" $linux[1]>Compatible</option>
                    </select>
                </label> <br>   
        HTML;
        $form .= <<<HTML
                <label for="mac">
                    MacOS <select name="mac" id="mac">
                        <option value="0" $mac[0]>Incompatible</option>
                        <option value="1" $mac[1]>Compatible</option>
                    </select>
                </label>   <br> 
        HTML;
        $selected = $developer == null ? "selected='selected'" : "";
        $form .= "\t\t\tDeveloper <select name='developer'>\n\t\t\t\t<option value='' {$selected}></option>";
        foreach (DeveloperCollection::findAll() as $developers) {
            // If the developer of the game is the developer that is about to be append to the page add the selected keyword.
            $selected = $developer?->getName() == $developers->getName() ? "selected='selected'" : "";
            $form .= "\t\t\t\t<option value='{$developers->getId()}' {$selected}>{$this->escapeString($developers->getName())}</option>\n";
        }

        $form .= "\t\t\t</select>\n\t\t\t<div class='categories_select'>Categories";
        foreach (CategoryCollection::findAll() as $category) {
            $checked = "";
            if (isset($categories)) {
                $checked = in_array($category->getDescription(), $categories) ? "checked" : "" ;
            }
            $form .= <<< HTML
                    <label>
                        <input type="checkbox" name="categories[]" {$checked} value="{$this->escapeString($category->getDescription())}"> {$this->escapeString($category->getDescription())}
                    </label>
            HTML;
        }
        $form .= "\t\t\t</div>\n\t\t\t<div class='genres_select'>Genres";
        foreach (GenreCollection::findAll() as $genre) {
            $checked = "";
            if (isset($genres)) {
                $checked = in_array($genre->getDescription(), $genres) ? "checked" : "";
            }
            $form .= <<< HTML
                    <label>
                        <input type="checkbox" name="genres[]" {$checked} value="{$this->escapeString($genre->getDescription())}"> {$this->escapeString($genre->getDescription())}
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

    /** Get the game from the POST query string
     *
     * @return void
     * @throws ParameterException If a wrong parameter is given
     */
    public function setGameFromQueryString()
    {
        $id = null;
        if (!empty($_POST["id"]) && ctype_digit($_POST["id"])) {
            $id = intval($_POST["id"]);
        }
        $this->checkCorrectQueryString();
        $name = $_POST["name"];
        $releaseYear = $_POST["releaseYear"];
        $shortDescription = $_POST["shortDescription"];
        $price = $_POST["price"];
        $windows = $_POST["windows"];
        $linux = $_POST["linux"];
        $mac = $_POST["mac"];


        $developer = !empty($_POST["developer"]) && ctype_digit($_POST["developer"]) ? intval($_POST["developer"]) : null;
        $metacritic = !empty($_POST["metacritic"]) && ctype_digit($_POST["metacritic"]) ? intval($_POST["metacritic"]) : null;
        $categories = $_POST["categories"];

        $genres = $_POST["genres"];
        // if there is a poster Id define it.
        $posterId = !empty($_POST["posterId"]) && ctype_digit($_POST["posterId"]) ? intval($_POST["posterId"]) : null;

        if (isset($_POST["poster"])) {
            $poster = Poster::create($_POST["poster"]);
            $poster->save();
            $posterId = $poster->getId();
        } elseif ($posterId == null) {
            $image = imagecreatefromjpeg("default-poster.php");
            ob_start();
            imagejpeg($image);
            $stringdata = ob_get_contents();
            ob_end_clean();
            $poster = Poster::create($stringdata);
            $poster->save();
            $posterId = $poster->getId();
        }

        $this->game = Game::create($name, $releaseYear, $shortDescription, $price, intval($windows), intval($mac), intval($linux), $posterId, intval($developer), $id, $metacritic);
        foreach ($genres as $genre) {
            $this->getGame()->assignGenre($genre->getId());
        }
        foreach ($categories as $category) {
            $this->getGame()->assignCategory($category->getId());
        }

    }


    /** Check if the query string is correct
     *
     * @return void
     * @throws ParameterException if there is an incorrect parameter given in the query string.
     */
    private function checkCorrectQueryString(): void
    {
        if (empty($_POST["name"])) {
            throw new ParameterException();
        }
        if (!empty($_POST["posterId"]) || !ctype_digit($_POST["posterId"])) {
            throw new ParameterException();
        }
        if (empty($_POST["releaseYear"]) || !ctype_digit($_POST["releaseYear"])) {
            throw new ParameterException();
        }
        if (empty($_POST["shortDescription"])) {
            throw new ParameterException();
        }
        if (empty($_POST["price"]) || !ctype_digit($_POST["price"])) {
            throw new ParameterException();
        }
        if (empty($_POST["poster"])) {
            throw new ParameterException();
        }
        if (empty($_POST["windows"]) || !ctype_digit($_POST["windows"])) {
            throw new ParameterException();
        }
        if (empty($_POST["linux"]) || !ctype_digit($_POST["linux"])) {
            throw new ParameterException();
        }
        if (empty($_POST["mac"]) || !ctype_digit($_POST["mac"])) {
            throw new ParameterException();
        }
        if (!isset($_POST["categories"]) || count($_POST["categories"]) == 0) {
            throw new ParameterException();
        }
        if (!isset($_POST["genres"]) || count($_POST["genres"]) == 0) {
            throw new ParameterException();
        }
    }
}
