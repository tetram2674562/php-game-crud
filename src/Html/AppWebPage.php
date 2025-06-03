<?php

declare(strict_types=1);

namespace Html;

class AppWebPage extends WebPage
{
    private string $menu = "";

    public function __construct(string $title = "")
    {
        WebPage::__construct($title);
        $this->appendCssUrl("/css/style.css");
    }

    /** Permet de rajouter du contenu au menu
     * @param string $content Le contenu à ajouter
     * @return void
     */
    public function addContentMenu(string $content): void
    {
        $this->menu .= $content;
    }

    public function toHTML(): string
    {
        $lastmod = AppWebPage::getLastModification();
        $html = <<< HTML
        <!doctype html>
        <html lang="fr">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1" />
                <title>{$this->getTitle()}</title>
                {$this->getHead()}
            </head>
            <body>
                <header class="header">
                    <h1>{$this->getTitle()}</h1>             
                </header>             
                <menu class="menu">
                    {$this->getMenu()}
                </menu>
                <div class="content">   
                    {$this->getBody()}
                </div>
                <footer class="footer">Date de dernière modification : $lastmod</footer>
            </body>
            
        HTML;


        return $html;
    }

    /** Récupère l'élément menu
     * @return string Le contenu de menu
     */
    public function getMenu(): string
    {
        return $this->menu;
    }
}
